<?php
//include "config.php";
//include "pusher_config.php";
//checkWheelTimer();
 
function checkWheelTimer() {
 

  global $pusher;
  $game_remaining_sec = getTimer();

 
$secoundly_trigger['update_timer']=$game_remaining_sec;
  if ($game_remaining_sec == 0) {
      // Set done
      $result = updateSql("UPDATE `wheel_rounds` SET `done` = '1'");   
      // Start new round
    //  $result = updateSql(" INSERT INTO `log`    (`id`, `text`, `created_at`) VALUES (NULL, 'Start new round $remaining_seconds',NOW());"); 
      $result = updateSql("INSERT INTO `wheel_rounds` (`id`, `winner_item`, `starts_at`, `done`)
                           VALUES (NULL, NULL, NOW(), 0)");
          $round = getRoundData(); 
          $secoundly_trigger['game_started']=$round;
        
    
  }

  if ($game_remaining_sec < 12 && $game_remaining_sec > 5) {
      // Get winner
      $round = getRoundData(); 
      $winner_item_this_round = readRowFromSql("SELECT `wheel_rounds`.`winner_item`
                                                FROM `wheel_rounds`
                                                WHERE `wheel_rounds`.`id`='$round'", true)['winner_item'];
      if ($winner_item_this_round == null) {
          $winnerItemId = getWinner($round);
          $insert_winner = updateSql("UPDATE `wheel_rounds` SET `winner_item` = '$winnerItemId'
                                      WHERE `wheel_rounds`.`id` = $round");
      $gameResult=    getGameResult($round, $winnerItemId);
      $secoundly_trigger['game_ended']=$gameResult;
      }
  }
 
  $pusher->trigger('wheel', 'data', $secoundly_trigger);
 
}
 


 
 
function getRoundData(){
 $current_round=readRowFromSql("SELECT  `wheel_rounds`.`id`   FROM `wheel_rounds`    
 WHERE ADDTIME(`wheel_rounds`.`starts_at`, '00:00:42') > NOW() ORDER BY id DESC LIMIT 1",true);
 return $current_round['id'];
}
function getWinner($round){
    echo 'get Winner called';
  $arr = readRowFromSql("SELECT `wheel_game_items`.`id`,
  COALESCE((`multiplier` *SUM(`wheel_rounds_bidders`.`value`)), 0)  as loss
   FROM `wheel_game_items`
 
   LEFT OUTER JOIN `wheel_rounds_bidders` ON
    `wheel_game_items`.`id`=`wheel_rounds_bidders`.`item` AND
 `wheel_rounds_bidders`.`round` = '$round'
   WHERE  `wheel_game_items`.`id`<9
   GROUP BY `wheel_game_items`.`id`
   ORDER BY (`multiplier` * COALESCE(SUM(`wheel_rounds_bidders`.`value`), 0)) 
  ",false);
  $last_loss=$arr[0]['loss'];
  $smallest=[];
  foreach($arr as $item){
    if($item['loss']==$last_loss){
      $smallest[]=$item['id'];
      $last_loss=$item['loss'];
    }else{
      break;
    }
  }
  $winner=  $smallest[array_rand($smallest)];   
  $s= json_encode($smallest, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);;
  updateSql(" INSERT INTO `log`  (`id`, `text`, `created_at`)
   VALUES (NULL,   'smallest ${s}, winner:  $winner',NOW());");   
     
   return $winner;
   }
 function getGameResult($round,$winnerItemId){
    global $pusher;
    $topThree = readRowFromSql("SELECT
    SUM(`wheel_rounds_bidders`.`value`* `wheel_rounds_bidders`.`multiplier`) AS won_value,
    `users`.`full_name`,
    `users`.`profile_pic`
FROM
    `wheel_rounds_bidders`
INNER JOIN `users` ON `users`.`uid` = `wheel_rounds_bidders`.`bidder`
WHERE
    `wheel_rounds_bidders`.`round` = '$round'
    AND `wheel_rounds_bidders`.`item` = '$winnerItemId'
GROUP BY
    `users`.`uid` 
ORDER BY
 SUM(`wheel_rounds_bidders`.`value`* `wheel_rounds_bidders`.`multiplier`) DESC
LIMIT 3;",false);   

echo '/n topThree : ';
echo json_encode($topThree, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $allBidders = readRowFromSql("SELECT `wheel_rounds_bidders`.`bidder` ,
    `users`.`last_wheel_pusher_id`
          FROM `wheel_rounds_bidders` 
          INNER JOIN `users` ON  `users`.`uid`= `wheel_rounds_bidders`.`bidder` 
           WHERE `wheel_rounds_bidders`.`round`='$round' GROUP BY `users`.`uid`
       ",false);     
       $allBiddersPotAndWonValue=[];
    foreach($allBidders as $bidder){
        $bidderUID=$bidder['bidder'];
        $bidderPusherId=$bidder['last_wheel_pusher_id'];

        $potValue = readRowFromSql("SELECT 
        SUM(`wheel_rounds_bidders`.`value`) AS potValue,
        wheel_rounds_bidders.is_gold as potWithGolds
           FROM 
           `wheel_rounds_bidders` 
           WHERE 
             `wheel_rounds_bidders`.`round` = '$round' AND 
              `wheel_rounds_bidders`.`bidder`='$bidderUID' AND
              `wheel_rounds_bidders`.`by_father_type`='0'  
       
        ",true) ;    
          $wonValue = readRowFromSql("SELECT IFNULL(SUM(`wheel_rounds_bidders`.`value` * `wheel_rounds_bidders`.`multiplier`), 0) AS wonValue 
          FROM `wheel_rounds_bidders` 
          WHERE `wheel_rounds_bidders`.`round` = '$round' 
          AND `wheel_rounds_bidders`.`bidder` = '$bidderUID' 
          AND `wheel_rounds_bidders`.`item` = '$winnerItemId';
          ;",true)['wonValue'];     
          $thisBidder['potValue']=$potValue['potValue'];
          $potWithGolds=$potValue['potWithGolds'];
          $thisBidder['potWithGolds']= $potWithGolds;
          $thisBidder['wonValue']=$wonValue;
          $thisBidder['uid']=$bidderUID;
 $allBiddersPotAndWonValue[]=$thisBidder;

 if($wonValue!=0){
  $cur_type=$potWithGolds?'g': 'c';
  addToWallet($bidderUID, $wonValue, $cur_type);
}
    }

   $result['allBiddersPotAndWonValue']=$allBiddersPotAndWonValue;
    $result['winnerItem']=$winnerItemId;
    $result['biggest_winner_this_round']=$topThree ;
return $result;
 
 
}

function getTimer(){

    $remaining_seconds=readRowFromSql("SELECT 
    CASE
        WHEN COUNT(*) = 0 THEN 0  -- No active rounds
        WHEN NOW() > ADDTIME(`wheel_rounds`.`starts_at`, '00:00:42') THEN 0  -- Round ended
        ELSE GREATEST(0, 42 - TIME_TO_SEC(TIMEDIFF(NOW(), `wheel_rounds`.`starts_at`))) -- Remaining seconds
    END AS remaining_seconds
FROM 
    `wheel_rounds`
    WHERE `done` =0
    ORDER BY `starts_at` LIMIT 1
    ;",true);
    $dd=$remaining_seconds['remaining_seconds'];
   //  $result = updateSql(" INSERT INTO `log`  (`id`, `text`, `created_at`) VALUES (NULL,    $dd,NOW());");   
     
    
   return $remaining_seconds['remaining_seconds'];
   }
?>
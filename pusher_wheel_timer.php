<?php
include "config.php";
require __DIR__ . '/vendor/autoload.php';
$app_id = '1768878';
$app_key = '2c6f687f7d54a2e4b6fa';
$app_secret = '2c858a4b20f1c8586f53';
$app_cluster = 'eu';

$pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, 
['cluster' => $app_cluster]);
//checkWheelTimer();
function checkWheelTimer(){    
    global $pusher;

     $game_remaining_sec=getTimer(); 
 //update game remaining_sec timer
    $pusher->trigger('wheel', 'update_timer',  $game_remaining_sec);
 

if($game_remaining_sec==0){
        //set done
        $result = updateSql("UPDATE `wheel_rounds` SET `done` = '1'");   
        //start new round
        $result = updateSql("INSERT INTO `wheel_rounds` 
        (`id`, `winner_item`, 
        `starts_at`,  `done`)
         VALUES (NULL, NULL, NOW(), 0);");   
     $round=getRoundData(); 
     $pusher->trigger('wheel', 'game_started', $round);
    
    }
  if($game_remaining_sec<12&&$game_remaining_sec>5){
    //get winner
    $round=getRoundData(); 
    $winner_item_this_round=readRowFromSql("SELECT  `wheel_rounds`.`winner_item`   FROM `wheel_rounds`    
    WHERE `wheel_rounds`.`id`='$round';",true)['winner_item'];
    if($winner_item_this_round!=null){
      $winnerItemId=getWinner($round);
      $insert_winner = updateSql("UPDATE `wheel_rounds` SET `winner_item` = '$winnerItemId'
      WHERE `wheel_rounds`.`id` = $round;");
      getGameResult($round,$winnerItemId);
    }
  
 } 

 
}
 


 
 
function getRoundData(){
 $current_round=readRowFromSql("SELECT  `wheel_rounds`.`id`   FROM `wheel_rounds`    
 WHERE ADDTIME(`wheel_rounds`.`starts_at`, '00:00:42') > NOW() ORDER BY id DESC LIMIT 1",true);
 return $current_round['id'];
//return $round;
}
function getWinner($round){
    echo 'get Winner called';
  $winnerSELECT = readRowFromSql("SELECT `wheel_game_items`.`id`
  FROM `wheel_game_items`

  LEFT OUTER JOIN `wheel_rounds_bidders` ON
   `wheel_game_items`.`id`=`wheel_rounds_bidders`.`item` AND
`wheel_rounds_bidders`.`round` = '$round'
  WHERE  `wheel_game_items`.`id`<9
  GROUP BY `wheel_game_items`.`id`
  ORDER BY (`multiplier` * COALESCE(SUM(`wheel_rounds_bidders`.`value`), 0)) 
  LIMIT 1;");   
  if($winnerSELECT==null){
    $winner=1;
  }else{
    $winner=$winnerSELECT['id'];
  }
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
        SUM(`wheel_rounds_bidders`.`value`) AS potValue
           FROM 
           `wheel_rounds_bidders` 
           WHERE 
             `wheel_rounds_bidders`.`round` = '$round' AND 
              `wheel_rounds_bidders`.`bidder`='$bidderUID'   
        ",true)['potValue'];    
          $wonValue = readRowFromSql("SELECT
           SUM(`wheel_rounds_bidders`.`value`*`wheel_rounds_bidders`.`multiplier`)
            AS wonValue FROM `wheel_rounds_bidders`
             WHERE `wheel_rounds_bidders`.`round` = '$round' 
             AND `wheel_rounds_bidders`.`bidder`='$bidderUID'
          AND `wheel_rounds_bidders`.`item`='1'
          ;",true)['wonValue'];     
          $thisBidder['potValue']=$potValue;
          $thisBidder['wonValue']=$wonValue;
          $thisBidder['uid']=$bidderUID;
 $allBiddersPotAndWonValue[]=$thisBidder;
    }
   // $result['potValue']=$potValue;
   // $result['wonValue']=$wonValue;
   $result['allBiddersPotAndWonValue']=$allBiddersPotAndWonValue;
    $result['winnerItem']=$winnerItemId;
    $result['biggest_winner_this_round']=$topThree ;
  //todo  pusher.sendToUser("$bidderPusherId", "game_ended",$result);
  $pusher->trigger('wheel', 'game_ended', $result);
 
}

function getTimer(){
    //rest or game
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
     
    // return 12;
   return $remaining_seconds['remaining_seconds'];
   }
?>
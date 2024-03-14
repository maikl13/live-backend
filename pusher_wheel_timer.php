<?php
include "config.php";
require __DIR__ . '/vendor/autoload.php';
$app_id = '1768878';
$app_key = '2c6f687f7d54a2e4b6fa';
$app_secret = '2c858a4b20f1c8586f53';
$app_cluster = 'eu';

$pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, 
['cluster' => $app_cluster]);
 
function checkWheelTimer(){    
    global $pusher;
     $game_remaining_sec=getTimer(); 
    
 
 //update game remaining_sec timer
  $game_remaining_to_be_back= calculateGameRemainingToBeBack($game_remaining_sec);
  updateSql("INSERT INTO `log` (`id`, `text`, `created_at`) VALUES (NULL, '$game_remaining_to_be_back', NOW());"); 
   $pusher->trigger('wheel', 'update_timer',  $game_remaining_to_be_back);
 

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

if($game_remaining_sec==12){
     
    //get winner
    $round=getRoundData(); 
    //todo case no winner defalut
    $winner=  getWinner($round)['id'];
 $insert_winner = updateSql("UPDATE `wheel_rounds` SET `winner_item` = '$winner'
  WHERE `wheel_rounds`.`id` = $round;");       
 
 //$pusher->trigger('wheel', 'game_ended',$winner);
} 

 
}
function calculateGameRemainingToBeBack($remaining_seconds) {
    if ($remaining_seconds > 11) {
        $game_remaining_to_be_back = $remaining_seconds - 12;
    } else if ($remaining_seconds >= 6) {
        $game_remaining_to_be_back = $remaining_seconds - 6;
    } else {
        $game_remaining_to_be_back = $remaining_seconds;
    }
    
    return max($game_remaining_to_be_back, 0);
}


 
 
function getRoundData(){
 $current_round=readRowFromSql("SELECT  `wheel_rounds`.`id`   FROM `wheel_rounds`    
 WHERE ADDTIME(`wheel_rounds`.`starts_at`, '00:00:40') > NOW() ORDER BY id DESC LIMIT 1",true);
return $current_round['id'];
}
function getWinner($round){
  $winner = readRowFromSql("SELECT 
    `wheel_game_items`.`id`,
    `wheel_game_items`.`value`,
    COALESCE(SUM(`wheel_rounds_bidders`.`value`), 0) AS pot,
     `wheel_game_items`.`value`*COALESCE(SUM(`wheel_rounds_bidders`.`value`), 0)  as final_value
    FROM 
    `wheel_game_items` 
    INNER  JOIN 
    `wheel_rounds_bidders` ON `wheel_game_items`.`id` = `wheel_rounds_bidders`.`item`
    AND `wheel_rounds_bidders`.`round` = '$round'
    GROUP BY
    `wheel_game_items`.`id`,
    `wheel_game_items`.`value`
    ORDER BY (`wheel_game_items`.`value`*COALESCE(SUM(`wheel_rounds_bidders`.`value`), 0) ) 
    LIMIT 1;");   
  
   return $winner;
   }
 function getGameResult($round){
    $winnerItem = getWinner($round);
    $winnerItemId= $winnerItem['id'];
    $winnerItemValue= $winnerItem['value'];
    $topThree = readRowFromSql("SELECT 
    COALESCE(SUM(`wheel_rounds_bidders`.`value`), 0)*$winnerItemValue AS won_value,
     `users`.`full_name`,
      `users`.`profile_pic`
    FROM 
    `wheel_rounds_bidders` 
    INNER JOIN `users` on `users`.`uid`=`wheel_rounds_bidders`.`bidder`
    WHERE 
      `wheel_rounds_bidders`.`round` = '$round' AND  `wheel_rounds_bidders`.`item`='$round'
    GROUP BY
    `users`.`id`
    ORDER BY  COALESCE(SUM(`wheel_rounds_bidders`.`value`), 0)  DESC
    LIMIT 3;",false);   
    $allBidders = readRowFromSql("SELECT `wheel_rounds_bidders`.`bidder` ,
    `users`.`last_wheel_pusher_id`
          FROM `wheel_rounds_bidders` 
          INNER JOIN `users` ON  `users`.`uid`= `wheel_rounds_bidders`.`bidder` 
          WHERE `wheel_rounds_bidders`.`round`='$round'
       ",false);     
    foreach($allBidders as $bidder){
        $bidderUID=$bidder['bidder'];
        $bidderPusherId=$bidder['last_wheel_pusher_id'];

        $bidderGameData = readRowFromSql("
        SELECT 
    COALESCE(SUM(`wheel_rounds_bidders`.`value`), 0) AS potValue,
        COALESCE(SUM(wheel_rounds_bidders_on_the_winning_item.`value`), 0) * '$winnerItemValue' AS wonValue
    FROM 
    `wheel_rounds_bidders` 
    LEFT OUTER JOIN `wheel_rounds_bidders` wheel_rounds_bidders_on_the_winning_item ON 
    wheel_rounds_bidders_on_the_winning_item.bidder=`wheel_rounds_bidders`.`bidder` AND wheel_rounds_bidders_on_the_winning_item.round=`wheel_rounds_bidders`.`round` AND
    wheel_rounds_bidders_on_the_winning_item.item='$winnerItemId'
    WHERE 
      `wheel_rounds_bidders`.`round` = '$round' AND  `wheel_rounds_bidders`.`bidder`='$bidderUID'
    LIMIT 1;
        ",false);     
     $result[]=$bidderGameData;
     $result['winnerItem']=$winnerItemId;
     $result['biggest_winner_this_round']=$topThree ;
     pusher.sendToUser("$bidderPusherId", "game_ended",$result);
    }
 
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
     
 
   return $remaining_seconds['remaining_seconds'];
   }
?>
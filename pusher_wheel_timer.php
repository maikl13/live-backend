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
 
 //update game remaining_sec timer
 
  $game_remaining_to_be_back= calculateGameRemainingToBeBack($game_remaining_sec);
  updateSql("INSERT INTO `log` (`id`, `text`, `created_at`) VALUES (NULL, '$game_remaining_to_be_back', NOW());"); 
   
   $pusher->trigger('wheel', 'update_timer',  $game_remaining_to_be_back);
 


if($game_remaining_sec==12){
     
    //get winner
    $round=getRoundData(); 
    $winner=  getWinner($round);
 $insert_winner = updateSql("UPDATE `wheel_rounds` SET `winner_item` = '$winner'
  WHERE `wheel_rounds`.`id` = $round;");       
 
 $pusher->trigger('wheel', 'game_ended',$winner);
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
    $wheel_game_items = readRowFromSql("SELECT 
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
    ORDER BY (`wheel_game_items`.`value`*COALESCE(SUM(`wheel_rounds_bidders`.`value`), 0) ) DESC
    LIMIT 1;");   
    if($wheel_game_items==null){
        $winner=1;
    }else{
        $winner['id'];
    }
   return $winner;
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

<?php
/*
include "config.php";
require __DIR__ . '/vendor/autoload.php';
$app_id = '1768878';
$app_key = '2c6f687f7d54a2e4b6fa';
$app_secret = '2c858a4b20f1c8586f53';
$app_cluster = 'eu';

$pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, 
['cluster' => $app_cluster]);

$game_remaining_sec=getTimer(); 
//update game remaining_sec timer
$pusher->trigger('wheel', 'updatetimer', array( 'game_remaining_sec' => $game_remaining_sec));

if($game_remaining_sec==-5){
    //start new round
    $result = updateSql("INSERT INTO `wheel_rounds` (`id`, `winner_item`, 
    `starts_at`, `ends_at`, `done`)
     VALUES (NULL, NULL, NOW(), NOW() + INTERVAL 35 SECOND, 0);");   
 $round=getRoundData(); 
// $result['action']='game_started';
 //$result['data']=$round;
 $pusher->trigger('wheel', 'game_started', array( 'round' => $round));

}
if($game_remaining_sec==0){
    //get winner
    $round=getRoundData(); 
    $winner=  getWinner($round);
 $insert_winner = updateSql("UPDATE `wheel_rounds` SET `winner_item` = '$winner'
  WHERE `wheel_rounds`.`id` = $round;");       
 //$result['action']='game_ended';
 //$result['data']=$winner;
 $pusher->trigger('wheel', 'game_ended', array( 'winner' => $winner));
} 



 
 
function getRoundData(){
 $current_round=readRowFromSql("SELECT  `wheel_rounds`.`id`   FROM `wheel_rounds`    
WHERE `ends_at` > CURDATE()",true);
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
    ORDER BY (`wheel_game_items`.`value`*COALESCE(SUM(`wheel_rounds_bidders`.`value`), 0) ) DESC
    LIMIT 1;");   
   return $winner['id'];
   }
   function getTimer(){
    //rest or game
    $remaining_seconds=readRowFromSql("SELECT 
    CAST(TIME_TO_SEC(TIMEDIFF(`wheel_rounds`.`starts_at`, NOW())) AS UNSIGNED) AS remaining_seconds
    FROM 
    `wheel_rounds`
    WHERE 
    `wheel_rounds`.`ends_at` > NOW() - INTERVAL 5 SECOND;",true)['remaining_seconds'];
   return $remaining_seconds;
   }
   */
?>

<?php
include "config.php";




$task = $_GET['task'];
$user_uid = $_GET['user_uid'];

 
 
 
   
  $taskCrystalsProfit=(readRowFromSql("SELECT  `dialy_tasks`.`crystal` FROM `dialy_tasks` WHERE  `dialy_tasks`.`id`='$task'", true))['crystal'];
  $profit = updateSql("UPDATE `users` SET `crystals` =crystals+ $taskCrystalsProfit WHERE `users`.`uid` = '$user_uid';");
 $check = updateSql("UPDATE `tasks_last_time` SET `last_profit_added_to_wallet` = '1'
 WHERE `tasks_last_time`.`task` = '$task' AND `tasks_last_time`.`user`='$user_uid';");

 

echo json_encode($profit, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


 



?>
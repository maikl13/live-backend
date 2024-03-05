<?php
include "config.php";




$task = $_GET['task'];
$user_uid = $_GET['user_uid'];

 
 
 
   
  $taskCrystalsProfit=(readRowFromSql("SELECT  `improvement_tasks`.`reward_value` FROM `improvement_tasks` WHERE  `improvement_tasks`.`id`='$task'", true))['reward_value'];
  $profit = updateSql("UPDATE `users` SET `crystals` =crystals+ $taskCrystalsProfit WHERE `users`.`uid` = '$user_uid';");
 $check = updateSql("UPDATE `users_done_onetime_tasks` SET `profit_added_to_wallet` = '1'
 WHERE `users_done_onetime_tasks`.`task` = '$task' AND `users_done_onetime_tasks`.`user`='$user_uid';");

 

echo json_encode($profit, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


 



?>
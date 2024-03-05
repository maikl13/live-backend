<?php
include "config.php";
 
$user= $_GET['user'];
 
 $result = readRowFromSql("
 SELECT`users`.`uid`, `users`.`full_name`
 ,`users`.`profile_pic` ,`users`.`bio` ,`users`.`gender` ,`users`.`current_premium_subscription` FROM `blocked_users`
 INNER JOIN `users` ON `users`.`uid`=`blocked_users`.`blocked`
  WHERE `blocked_users`.`blocker`='$user' ", false);
 
 
         echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 


?>
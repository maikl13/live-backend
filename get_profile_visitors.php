<?php
include "config.php";


$user_uid = $_GET['user_uid'];

$result=array();
 $users = readRowFromSql("SELECT`users`.`uid`, `users`.`full_name`
 ,`users`.`profile_pic` ,`users`.`bio` ,`users`.`gender`,`users_visitors`.`datetime` ,
 `users`.`current_premium_subscription`,
 `users`.`current_vip_subscription`
 FROM `users_visitors`
INNER JOIN `users` ON `users`.`uid`=`users_visitors`.`visitor_uid`
 WHERE `users_visitors`.`visited_uid`='$user_uid'
 
  ORDER BY  `users_visitors`.`datetime` DESC
", false);



echo json_encode($users, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
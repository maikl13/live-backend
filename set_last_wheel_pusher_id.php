<?php
include "config.php";
  
$uid =$_GET['uid'];
$last_wheel_pusher_id =$_GET['last_wheel_pusher_id'];
updateSql("UPDATE `users` SET`users`.`last_wheel_pusher_id` = 
'$last_wheel_pusher_id' WHERE `users`.`uid`='$uid'"); 
?>
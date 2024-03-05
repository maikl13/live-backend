<?php
include "config.php";

$room=$_GET['room'];
$user=$_GET['user'];
$admin=$_GET['admin'];


 $result =  updateSql("DELETE FROM `rooms_banned_from_chat_users` WHERE `rooms_banned_from_chat_users`.`room`= '$room'
AND 
`rooms_banned_from_chat_users`.`user`= '$user'" );
 


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
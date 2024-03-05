<?php
include "config.php";



$user_uid =$_GET['user_uid'];
$room_id =$_GET['room_id'];
 
 

 $result = updateSql("UPDATE `user_rooms` SET `is_joined` = '0' WHERE `user_rooms`.`user_uid`='$user_uid' AND room_id='$room_id';");
 
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
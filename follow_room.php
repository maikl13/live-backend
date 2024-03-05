<?php
include "config.php";


$user_uid =$_GET['user_uid'];
$room_id =$_GET['room_id'];
$follow =$_GET['follow'];

 $found = readRowFromSql("SELECT `user_rooms`.`id` FROM `user_rooms` WHERE `user_rooms`.`user_uid`='$user_uid'
AND `user_rooms`.`room_id` =$room_id", false);


if($found!=null){
    $result = updateSql("UPDATE `user_rooms` SET `following` = '$follow' WHERE `user_rooms`.`user_uid`='$user_uid' AND room_id='$room_id';");

}else{
    $result = updateSql("INSERT INTO `user_rooms` (`id`, `user_uid`, `room_id`, `is_joined`, `is_online`, `level`, `following`, `enter_datetime`) VALUES (NULL, '$user_uid', '$room_id', '0', '0', NULL, '$follow', CURRENT_TIMESTAMP);");

}
  
 
  echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$room =$_GET['room'];
 $is_turned_on=$_GET['is_turned_on'];
 if($is_turned_on=='0'){
     $removeUsers = updateSql("DELETE FROM `room_mic_application` WHERE `room_mic_application`.`room` = '$room'");
 }
 
   $result = updateSql("UPDATE `rooms` SET `mic_application_is_turned_on` = '$is_turned_on' WHERE `rooms`.`id`='$room';");
        
 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
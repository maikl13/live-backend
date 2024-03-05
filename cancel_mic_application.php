<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$room =$_GET['room'];
 
$result = updateSql("DELETE FROM `room_mic_application` WHERE `room_mic_application`.`user` = '$uid' AND `room_mic_application`.`room` = '$room'");
 
 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
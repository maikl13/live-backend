<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$room =$_GET['room'];
 
$result = updateSql("INSERT INTO `room_mic_application` (`id`, `room`, `user`) VALUES (NULL, '$room', '$uid');");
 
 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
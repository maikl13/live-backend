<?php
include "config.php";

$user_uid =$_GET['user_uid'];
$room_id =$_GET['room_id'];
$announcement =$_GET['announcement'];



   
   
   $result = updateSql("UPDATE `rooms` SET `description` = '$announcement' WHERE `rooms`.`id` = '$room_id';");
        

  


   
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
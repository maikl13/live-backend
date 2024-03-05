<?php
include "config.php";
include "pay.php";

$room_grade = $_GET['room_grade'];
$user = $_GET['user'];

$price=readRowFromSql("SELECT  `room_upgrade_types`.`cost` FROM `room_upgrade_types` WHERE `room_upgrade_types`.`id`='$room_grade'", true)['cost'];
 if(payNow($user,$price,'g')){
     $result = updateSql("UPDATE `rooms` SET `room_grade` = '$room_grade' WHERE `rooms`.`creator_uid` = '$user';");
 }


          
          
          
      


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";



$user =$_GET['user'];

 


$room_grade = readRowFromSql("SELECT `rooms`.`room_grade` FROM `rooms` WHERE `rooms`.`creator_uid`='$user'
 ", true)['room_grade'];
 
 
echo json_encode($room_grade, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
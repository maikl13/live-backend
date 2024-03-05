<?php
include "config.php";
include "room_level_manager.php";

$user =$_GET['user'];
$task =$_GET['task'];
$room =$_GET['room'];
 

onRoomLevelTaskDone($user,$room,$task,1);
 
 
?>
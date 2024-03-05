<?php
include "config.php";
include "level_manager.php";

$uid =$_GET['uid'];
$task =$_GET['task'];
$repeats =$_GET['repeats'];

    onTaskDone($uid,$repeats,$task);
  

 
?>
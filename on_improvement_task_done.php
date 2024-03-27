<?php
include "config.php";
include 'improvement_tasks_manager.php';



$task = $_GET['task'];
$user_uid = $_GET['user_uid'];


onDone($task,$user_uid,1);
 

 



?>
<?php
include "config.php";

$event = $_GET['event'];
$user= $_GET['user'];


$result = updateSql("DELETE FROM `events` WHERE `events`.`id` = $event");  
          
      

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
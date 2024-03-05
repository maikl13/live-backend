<?php
include "config.php";

 
 
 
$battle = $_GET['battle']; 
  
$remaining_seconds= readRowFromSql("SELECT `remaining_seconds` FROM `pk_battles` WHERE `pk_battles`.`id`='$battle'", true)['remaining_seconds'];

 echo $remaining_seconds;
 
?>
<?php
include "config.php";
 
 
$user=$_GET['user'];
updateSql("UPDATE `users` SET `is_online`=1,`last_active`=NOW() WHERE  `users`.`uid`='$user'");
 
  
?>
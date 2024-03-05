<?php
include "config.php";


$uid =$_GET['uid'];


$user = readRowFromSql("SELECT `users`.`crystals`,`users`.`gold` FROM `users` WHERE `users`.`uid` = '$uid'
", true);



echo json_encode($user, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
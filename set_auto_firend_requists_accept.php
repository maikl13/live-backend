<?php
include "config.php";


$user  =$_GET['user'];
$statue =$_GET['statue'];
 $result = updateSql("UPDATE `users` SET `auto_firend_requists_accept` = '$statue' WHERE `users`.`uid`='$user';");
 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
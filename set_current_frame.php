<?php
include "config.php";

$uid = $_GET['uid'];
$frame = $_GET['frame'];


  $result = updateSql("UPDATE `users` SET `used_frame` = '$frame' WHERE `users`.`uid`='$uid'");


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";

$uid = $_GET['uid'];
$vehicle = $_GET['vehicle'];



$currentVehicle = readRowFromSql("SELECT `users`.`vehicle` FROM `users` WHERE `users`.`uid`='$uid'", true)['vehicle'];
if($currentVehicle==$vehicle){
      $result = updateSql("UPDATE `users` SET `vehicle` = NULL WHERE `users`.`uid`='$uid'");
}else{
      $result = updateSql("UPDATE `users` SET `vehicle` = '$vehicle' WHERE `users`.`uid`='$uid'");
}


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
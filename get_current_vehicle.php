<?php
include "config.php";

$uid = $_GET['uid'];
 



$currentVehicle = readRowFromSql("SELECT `vehicles`.* FROM `users`
INNER JOIN `vehicles` on `vehicles`.`id`=`users`.`vehicle`
INNER JOIN `users_vehicles`ON `users_vehicles`.`vehicle` =`vehicles`.`id`
AND `users_vehicles`.`user`=`users`.`uid`
WHERE `users`.`uid`='$uid'
 AND CURDATE()< DATE_ADD(`users_vehicles`.`purchase_date`, INTERVAL 30 DAY) 
 ", true) ;
 


echo json_encode($currentVehicle, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
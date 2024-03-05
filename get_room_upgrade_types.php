<?php
include "config.php";



$room_upgrade_typess= readRowFromSql("SELECT * FROM `room_upgrade_types`"
, false);


   
 
echo json_encode($room_upgrade_typess, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";
///// our real code //////
$room_lock_packages_pricing = readRowFromSql("SELECT * FROM `room_lock_packages_pricing` ", false);
$result  = array();
foreach ($room_lock_packages_pricing as $room_lock_package_pricing) {
    $result[]= $room_lock_package_pricing;
}
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
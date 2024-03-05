<?php
include "config.php";
///// our real code //////
$coins_packages = readRowFromSql("SELECT * FROM `coins_packages` ", false);
$result  = array();
foreach ($coins_packages as $coins_package) {
    $result[]= $coins_package;
}
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
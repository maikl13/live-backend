<?php
include "config.php";
 
$wheel_currencies=readRowFromSql("SELECT * FROM `wheel_currencies`  ",false);
echo json_encode($wheel_currencies, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 
?>
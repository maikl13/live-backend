<?php
include "config.php";
$themes = readRowFromSql("SELECT * FROM `customtheme_paying_modes` ", false);
echo json_encode($themes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
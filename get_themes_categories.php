<?php
include "config.php";
$themes = readRowFromSql("SELECT `categories_of_themes`.`id`,`categories_of_themes`.`title` FROM `categories_of_themes`", false);
echo json_encode($themes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";
 
$result = readRowFromSql("SELECT * FROM `crazy_words_lists` ", false);
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
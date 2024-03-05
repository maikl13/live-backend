<?php
include "config.php";

  
$hashtags = readRowFromSql("SELECT * FROM hashtags", false);

echo json_encode($hashtags, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
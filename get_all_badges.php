<?php
include "config.php";



$crazy_words= readRowFromSql("SELECT * FROM `badges`"
, false);


   
 
echo json_encode($crazy_words, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
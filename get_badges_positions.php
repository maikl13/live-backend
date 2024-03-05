<?php
include "config.php";



$badges_positions= readRowFromSql("SELECT * FROM `badges_positions`"
, false);


   
 
echo json_encode($badges_positions, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
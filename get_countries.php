<?php
include "config.php";

  
$countries = readRowFromSql("SELECT * FROM countries
", false);

   


echo json_encode($countries, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
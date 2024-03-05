<?php
include "config.php";


 
 $result = readRowFromSql("SELECT rooms.title 
FROM `rooms`
", false);
 
 

  echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

 
?>
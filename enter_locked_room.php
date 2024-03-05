<?php
include "config.php";


$user_uid = $_GET['user_uid'];
$room = $_GET['room'];
$passcode = $_GET['passcode'];
 



      

  


   
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
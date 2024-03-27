<?php
include "config.php";
include "pay.php";
 
$auction = $_GET['auction'];
$user = $_GET['user'];
 
 
 $price=4000;
  $result=payNow($user,$price,'g');
  if($result){
       updateSql("UPDATE `counter` SET `winner` = '$user',`sold` = '1'   WHERE `counter`.`id` = $auction;");    
       
  }
  
 
 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
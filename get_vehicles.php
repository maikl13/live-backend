<?php
include "config.php";

 $uid =$_GET['uid'];

$result=array();
$vehicles= readRowFromSql("SELECT * FROM `vehicles`"
, false);


      foreach ($vehicles as $vehicle) {
      $vehicle["user_can_get_it"]="0";
      $vehicle["minimum_premium_position_title"]="Minister";
      $result[]=$vehicle;
    
   }
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
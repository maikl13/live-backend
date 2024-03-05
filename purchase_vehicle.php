<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$vehicle =$_GET['vehicle'];
 
    $price= readRowFromSql("
SELECT  `vehicles`.`price` FROM `vehicles` WHERE  `vehicles`.`id`='$vehicle'
 ", true)['price'];

   $result = updateSql("INSERT INTO `users_vehicles` (`id`, `user`, `vehicle`, `purchase_date`) 
   VALUES (NULL, '$uid', '$vehicle', CURDATE());");
   if($price!=0){
       $payed=payNow($uid,$price,'g');
   }


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
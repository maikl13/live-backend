<?php
include "config.php";
include "pay.php";
  include "vip_manager.php";
  
$uid =$_GET['uid'];
$lock_package =$_GET['lock_package'];
$room_id = readRowFromSql("
SELECT `rooms`.`id`
FROM `rooms`
WHERE `rooms`.`creator_uid`='$uid' 
 ", true)['id'];
 if($room_id!=null){
  $price= readRowFromSql("
  SELECT  `room_lock_packages_pricing`.`value_in_coins` FROM `room_lock_packages_pricing` WHERE  `room_lock_packages_pricing`.`id`='$lock_package'
   ", true)['value_in_coins'];
  

   $price=get_price_after_store_discount($uid,$price);
     $INSERT = updateSql("INSERT INTO `rooms_locks` (`id`, `room`, `lock_package`, `purchase_date`) VALUES (NULL, '$room_id', '$lock_package', CURRENT_TIMESTAMP);");
  $payed=payNow($uid,$price,'g');

  if($payed){

      //ع اساس ان الجولد بدولار لان المكافئاة المفروض ع حسب الدورلار
   earnVipPoints($uid,$price); 

  }

  $result['succeeded']=$payed;

  $result['message']='';  
 
 }else{
  $result['succeeded']=0;
  $result['message']='you must create a room first';  

 }

 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
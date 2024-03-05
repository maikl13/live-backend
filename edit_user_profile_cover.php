<?php
include "config.php";


$user_uid = $_GET['user_uid'];
$image = $_GET['image'];



$data=readRowFromSql("SELECT `users`.`current_premium_subscription`
 ,`users`.`current_vip_subscription`
FROM `users` 
WHERE `users`.`uid`='$user_uid'", true);
 
 
 

$is_premuim=$data['current_premium_subscription']==NULL?0:1;


   if($is_premuim){
 
   
 $premiumSubscription=$data['current_premium_subscription'];
  
if($premiumSubscription>=4){
     $result_add = updateSql("UPDATE `users` SET `profile_cover` = '$image' WHERE `users`.`uid` = '$user_uid';");
   }
   }else{
     echo "NotRequiredPremiumSubscription";
   }


   
 
  


   
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
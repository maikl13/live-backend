<?php
include "premium_manager.php";
  
header('Content-Type: application/json');  
 

try {
$data = json_decode(file_get_contents('php://input'), true);
     $event  =$data['event'];
$eventType =$event['type']; 
} catch(\UnexpectedValueException $e) { 
  echo '⚠️  Webhook error while parsing basic request.';
  http_response_code(400);
  exit();
} catch(Exception $e) { 
  echo '⚠️  Webhook error . $e';
  http_response_code(400);
  exit();
}  
switch ($eventType) {
   case 'INITIAL_PURCHASE':
   //new || downgrade
   $user_uid= $event['app_user_id']; 
   $subscription_level=getSubscriptionByProductId($event['product_id']);
  subscribeToPremium($user_uid,$subscription_level);
    break;
   case 'RENEWAL':
  //renew || downgrade       
   $user_uid= $event['app_user_id']; 
   $subscription_level=getSubscriptionByProductId($event['product_id']);
  subscribeToPremium($user_uid,$subscription_level);
     $rebate=readRowFromSql("SELECT  `premium_subscription`.`rebate`  FROM `premium_subscription` WHERE `premium_subscription`.`id`='$subscription_level'", true)['rebate'] ;
  $wallet_transfers = updateSql("INSERT INTO `wallet_transfers` 
  (`id`, `value`, `wallet_type`, `reason`, `transfer_type`, `datetime`, `user`) VALUES 
  (NULL, '$rebate', 'g', 'premiumRenewalRebate', 'deposit', CURRENT_TIMESTAMP, '$user_uid');");     
    break;
   case 'PRODUCT_CHANGE':
    //should be used only for upgrades   
   $user_uid= $event['app_user_id']; 
   $subscription_level=getSubscriptionByProductId($event['product_id']);
   $new_subscription_level=getSubscriptionByProductId($event['new_product_id']);
   subscribeToPremium($user_uid,$new_subscription_level);
    break;
   case 'EXPIRATION':
    $user_uid= $event['app_user_id']; 
   subscriptionCancellation($user_uid);
    break;
 
}

http_response_code(200);

  

?>
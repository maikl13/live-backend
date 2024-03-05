 
<?php
include "premium_manager.php";
include "pay.php";
include "vip_manager.php";
 
$user_uid = $_GET['user_uid'];  
$subscription_level = $_GET['subscription_level'];  
$is_renew= $_GET['is_renew'];  
 
 

     $data= readRowFromSql("   SELECT `premium_subscription`.`price` 
    ,`premium_subscription`.`renewal` 
    
    FROM `premium_subscription` WHERE `premium_subscription`.`id`=$subscription_level
 ", true);
  $price=0;

    if($is_renew==1){
        $price=$data['renewal'];
    
    }else{
           $price=$data['price'];
    }
   
     
     if(payNow($user_uid,$price,'g')){
     earnVipPoints($user_uid,$price);
         subscribeNow($user_uid,$subscription_level);
           
     }else{
     
           $response = [
        'status' => 'error',
        'message' => 'You do not have enough golds.'
    ];
    echo json_encode($response);
     }

function subscribeNow($user_uid,$subscription_level){
    $success=subscribeToPremium($user_uid,$subscription_level);
if ($success) {

    $response = [
        'status' => 'success',
        'message' => 'Initial subscription recorded successfully.'
    ];
    echo json_encode($response);
} else {
 
    $response = [
        'status' => 'error',
        'message' => 'Error recording initial subscription.'
    ];
    echo json_encode($response);
}
}

?>
 
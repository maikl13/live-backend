<?php
 
include "level_manager.php";


 function addGiftRebateToRebatesTable($uid, $giftPrice)
{
      
   $myPremeiumSubscription=readRowFromSql("SELECT `users`.`current_premium_subscription` 
   FROM `users` WHERE `users`.`uid`='$uid'", true)['current_premium_subscription'] ;
   if($myPremeiumSubscription!=null){
  
     if($myPremeiumSubscription>3){
                $discountRatio = readRowFromSql("SELECT `premium_subscription`.`sending_gifts_discount`  FROM `premium_subscription` 
                WHERE `premium_subscription`.`id` = '$myPremeiumSubscription'", true)['sending_gifts_discount'];
   //  toInt?
  $rebateValue =  $giftPrice * ($discountRatio/100);
  
 $result = updateSql("INSERT INTO `gifts_rebates` (`id`, `user`, `value`, `gained`, `datetime) VALUES (NULL, '$uid', '$rebateValue', '0',CURRENT_TIMESTAMP);");
     }

 
   }

 
 
}
 function insertGiftRebateValueIntoWallet($uid,$rebateId)
{
    $rebateValue= readRowFromSql("SELECT `gifts_rebates`.`value` FROM `gifts_rebates` WHERE  `gifts_rebates`.`id`='$rebateId'", true)['value'];
 $result1 = updateSql("INSERT INTO `wallet_transfers` (`id`, `value`, `wallet_type`, `reason`, `transfer_type`, `datetime`, `user`)
 VALUES (NULL, '3', '$rebateValue', 'giftsRebate', 'deposit', CURRENT_TIMESTAMP, '$uid');");
  addToWallet($uid, $rebateValue, 'g');
  $result2 = updateSql("UPDATE `gifts_rebates` SET `gained` = '1' WHERE `gifts_rebates`.`id` = $rebateId;");
return $result2;

}


 function get_price_after_store_discount($uid, $oldPrice)
{
      
$discountRatio=0;
   $meAsPremium=readRowFromSql("SELECT `users`.`current_premium_subscription` 
   FROM `users` WHERE `users`.`uid`='$uid'", true) ;
   if($meAsPremium!=null){
     $myPremeiumSubscription=$meAsPremium['current_premium_subscription'];
    
       $discountRatio = readRowFromSql("SELECT `premium_subscription`.`store_discount`  
 FROM `premium_subscription` WHERE `premium_subscription`.`id` = '$myPremeiumSubscription'
", true)['store_discount'];
   }
   //price after discount // toInt?
   $priceAfterDiscount = ($oldPrice-($oldPrice * ($discountRatio/100)));
    return $priceAfterDiscount;
}
function pay_gold($sender_gold, $gift_value, $sender_uid)
{
    $remain = $sender_gold - $gift_value;
    if ($remain != 0) {
        $pay = updateSql(
            "UPDATE `users` SET `gold` = '$remain' WHERE `users`.`uid` = '$sender_uid'"
        );
    }
}
function pay_crystals($sender_crystals, $gift_value, $sender_uid)
{
    $remain = $sender_crystals - $gift_value;
    if ($remain != 0) {
        $pay = updateSql(
            "UPDATE `users` SET `crystals` = '$remain' WHERE `users`.`uid` = '$sender_uid'"
        );
    }
}

function payNow($sender_uid, $price, $currency_type)
{
   
 
    switch ($currency_type) {
        case "c":
            $key = "crystals";
            $select = readRowFromSql(
                "SELECT `crystals` FROM `users` WHERE `users`.`uid` = '$sender_uid' ",
                true
            );
            $user_this_currency_value_in_wallet = $select["crystals"];
            break;
        case "g":
           
            $key = "gold";
            $select = readRowFromSql(
                "SELECT `gold` FROM `users` WHERE `users`.`uid` = '$sender_uid'",
                true
            );
            
            $user_this_currency_value_in_wallet = $select["gold"];
       
            break;
    }

    $remain = $user_this_currency_value_in_wallet - $price;
       
    if ($remain >= 0) {
        $pay = updateSql(
            "UPDATE `users` SET `$key` = '$remain' WHERE `users`.`uid` = '$sender_uid'"
        );
    
        $repeats = floor($price / 3);
    //  echo $repeats;
   
   onTaskDone($sender_uid,$repeats,1);
       
        return true;
    } else {
        
        return false;
    }
    

    
}

    function addToWallet($uid, $price, $currency_type)
{
    
    switch ($currency_type) {
        case "c":
            $code = "SET `crystals` = crystals+$price ";
    
            break;
        case "g":
          $code = "SET `gold` = gold+$price ";
            break;
    }
   $pay = updateSql(
            "UPDATE `users` $code WHERE `users`.`uid` = '$uid'"
        );
  
}
?>

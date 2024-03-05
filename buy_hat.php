<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$hat =$_GET['hat'];
$count =$_GET['count'];
$store =$_GET['store'];


$currency_type="";
$one_hat_price;

if($store=='g'){
   $one_hat_price=readRowFromSql("SELECT `hats`.`golds` FROM `hats` WHERE `hats`.`id`=$hat", true)['golds'];
   $one_hat_price=get_price_after_store_discount($uid,$one_hat_price);
   $currency_type='g';
}

if($store=='c'){
   $selected_hat=readRowFromSql("SELECT `products_to_buy_with_crystal`.`crystals` FROM `products_to_buy_with_crystal` WHERE `products_to_buy_with_crystal`.`product_id`=$hat", true); 
    $one_hat_price=$selected_hat['crystals'];
     $currency_type='c';
}

$finalPrice=$one_hat_price*$count;
        if(payNow($uid,$finalPrice,$currency_type)){
            $getOldData=readRowFromSql("SELECT `users_hats`.`id`,`users_hats`.`stock` FROM `users_hats` WHERE `users_hats`.`user_uid`='$uid' AND `users_hats`.`hat`=$hat", true); 
            if($getOldData!=null){
                $old_count_in_stock=$getOldData['stock'];
                $newCount=$old_count_in_stock+$count;
                 $old_id=$getOldData['id'];
                  $result = updateSql("UPDATE `users_hats` SET `stock` = '$newCount' WHERE `users_hats`.`id` = $old_id;");
                
            }else{
              
                    $result = updateSql("INSERT INTO `users_hats` (`id`, `user_uid`, `hat`, `stock`) VALUES (NULL, '$uid', '$hat', '$count');");
                   
                   
            }
        
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
       }else{
      
           echo "false";
       }

?>
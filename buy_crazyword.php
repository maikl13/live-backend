<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$crazyword =$_GET['crazyword'];
$count =$_GET['count'];
$store =$_GET['store'];


$currency_type="";
$one_crazyword_price;

if($store=='g'){
   $one_crazyword_price=readRowFromSql("SELECT `crazy_words`.`golds` FROM `crazy_words` WHERE `crazy_words`.`id`=$crazyword", true)['golds'];
   $one_crazyword_price=get_price_after_store_discount($uid,$one_crazyword_price);
   $currency_type='g';
}

if($store=='c'){
   $selected_crazyword=readRowFromSql("SELECT `products_to_buy_with_crystal`.`crystals` FROM `products_to_buy_with_crystal` WHERE `products_to_buy_with_crystal`.`product_id`=$crazyword", true); 
    $one_crazyword_price=$selected_crazyword['crystals'];
     $currency_type='c';
}

$finalPrice=$one_crazyword_price*$count;
        if(payNow($uid,$finalPrice,$currency_type)){
            $getOldData=readRowFromSql("SELECT `users_crazywords`.`id`,`users_crazywords`.`stock` FROM `users_crazywords` WHERE `users_crazywords`.`user_uid`='$uid' AND `users_crazywords`.`crazyword`=$crazyword", true); 
            if($getOldData!=null){
                $old_count_in_stock=$getOldData['stock'];
                $newCount=$old_count_in_stock+$count;
                 $old_id=$getOldData['id'];
                  $result = updateSql("UPDATE `users_crazywords` SET `stock` = '$newCount' WHERE `users_crazywords`.`id` = $old_id;");
                
            }else{
              
                    $result = updateSql("INSERT INTO `users_crazywords` (`id`, `user_uid`, `crazyword`, `stock`) VALUES (NULL, '$uid', '$crazyword', '$count');");
                   
                   
            }
        
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
       }else{
      
           echo "false";
       }

?>
<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$theme =$_GET['theme'];
$store =$_GET['store'];

$currency_type="";
$price;
if($store=='g'){
   $theme_price=readRowFromSql("SELECT `themes`.`golds` FROM `themes` WHERE `themes`.`id`=$theme", true); 
   $price=$theme_price['golds'];
   $currency_type='g';
}
if($store=='c'){
   $theme_price=readRowFromSql("SELECT `products_to_buy_with_crystal`.`crystals` FROM `products_to_buy_with_crystal` WHERE `products_to_buy_with_crystal`.`product_id`=$theme", true); 
    $price=$theme_price['crystals'];
     $currency_type='c';
}

        if(payNow($uid,$price,$currency_type)){
         $code="INSERT INTO `users_bought_themes` (`id`, `user_uid`, `theme`,`purchase_date`) 
         VALUES (NULL, '$uid', '$theme',CURDATE());";
           $result = updateSql($code);
 
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 
       }else{

           echo "false";
       }

?>
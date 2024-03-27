<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$theme =$_GET['theme'];
$store =$_GET['store'];

$my_room_level_selecet=readRowFromSql("SELECT `rooms`.`room_level` FROM `rooms`
WHERE `rooms`.`creator_uid` ='$uid'", true); 
 $my_room_level=0;
 if($my_room_level_selecet!=null){
  $my_room_level= $my_room_level_selecet['room_level'];
 }

$required_room_level=readRowFromSql("SELECT `themes`.`required_room_level` FROM `themes`
WHERE `themes`.`id`=$theme", true)['required_room_level']; 
if($required_room_level<=$my_room_level){
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
}else{
   echo "false";
}



?>
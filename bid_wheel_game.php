<?php
include "config.php";
include "pay.php";
 
 
 $user=$_GET['user'];
 $item =$_GET['item'];
 $value=$_GET['value'];
 $isGold=$_GET['is_gold'];
 $round=getRoundData(); 

 $type= $isGold?'g':'c';
 
  
  if(payNow($user,$value, $type)){
 
    $multiplier=readRowFromSql("SELECT  `wheel_game_items`.`value`
     FROM `wheel_game_items` WHERE `wheel_game_items`.`id`='$item'",true)['value'];
       
    if( $item ==9|| $item ==10){
 
     $products=readRowFromSql("SELECT `wheel_game_items`.`id` 
     FROM `wheel_game_items` WHERE `wheel_game_items`.`type_of`='$item'",false);
     foreach(  $products as   $product){
        $product_id=$product['id'];
        updateSql("INSERT INTO `wheel_rounds_bidders` 
        (`id`, `round`, `bidder`, `item`, `value`,`multiplier`) 
        VALUES 
        (NULL, '$round', '$user', '$product_id', '$value','$multiplier');");  
  
     }
    }
  else{
   
$code="INSERT INTO `wheel_rounds_bidders` 
(`id`, `round`, `bidder`, `item`, `value`,`multiplier`) 
VALUES 
(NULL, '$round', '$user', '$item', '$value','$multiplier');";
//echo $code;
        updateSql("$code");  
   
    }
    $result['succeeded']='true';
    $result['message']=''; 

  }else{
    $result['succeeded']='false';
    $result['message']='you do not have enough money';  
  }
 
function getRoundData(){
    $current_round=readRowFromSql("SELECT  `wheel_rounds`.`id`   FROM `wheel_rounds`    
    WHERE ADDTIME(`wheel_rounds`.`starts_at`, '00:00:42') > NOW() ORDER BY id DESC LIMIT 1",true);
    return $current_round['id'];
 }

 

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
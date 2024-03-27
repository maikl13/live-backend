<?php
include "config.php";
include "pay.php";
include 'improvement_tasks_manager.php';
 
 $user=$_GET['user'];
 $item =$_GET['item'];
 $value=$_GET['value'];
 $isGold=$_GET['is_gold'];
 $round=getRoundData(); 

 $type= $isGold?'g':'c';
 $bided_items_count=readRowFromSql("SELECT COUNT(DISTINCT `wheel_rounds_bidders`.`item`) as bided_items_count 
 FROM `wheel_rounds_bidders` 
 WHERE `wheel_rounds_bidders`.`round` = '$round'
 AND `wheel_rounds_bidders`.`bidder` = '$user'
 AND `wheel_rounds_bidders`.`item` NOT IN (9, 10);
",true)['bided_items_count'];

$bided_on_this_item_before=readRowFromSql("SELECT COUNT(`wheel_rounds_bidders`.`id`) as bided_items_count 
FROM `wheel_rounds_bidders` 
WHERE `wheel_rounds_bidders`.`round` = '$round'
AND `wheel_rounds_bidders`.`bidder` = '$user'
AND `wheel_rounds_bidders`.`item` = '$item';",true)['bided_items_count']>0;
$items_count_bid= $item ==9|| $item ==10?4:1;
$bided_items_count_after_the_bid=$items_count_bid+$bided_items_count;
if( $bided_on_this_item_before|| $bided_items_count_after_the_bid<=6){
  if(payNow($user,$value, $type)){
     onDone(15,$user,0);
    $multiplier=readRowFromSql("SELECT  `wheel_game_items`.`value`
     FROM `wheel_game_items` WHERE `wheel_game_items`.`id`='$item'",true)['value'];
       
    if( $item ==9|| $item ==10){
      updateSql("INSERT INTO `wheel_rounds_bidders` 
      (`id`, `round`, `bidder`, `item`, `value`,`multiplier`,
      `is_gold`,`by_father_type`) 
      VALUES 
      (NULL, '$round', '$user', '$item', '$value','$multiplier','$isGold','0');");  
 
     $products=readRowFromSql("SELECT `wheel_game_items`.`id` 
     FROM `wheel_game_items` WHERE `wheel_game_items`.`type_of`='$item'",false);
     foreach(  $products as   $product){
        $product_id=$product['id'];
        updateSql("INSERT INTO `wheel_rounds_bidders` 
        (`id`, `round`, `bidder`, `item`, `value`,`multiplier`,`is_gold`,`by_father_type`) 
        VALUES 
        (NULL, '$round', '$user', '$product_id', '$value','$multiplier','$isGold','1');");  
  
     }
    }
  else{
   
 
 
        updateSql("INSERT INTO `wheel_rounds_bidders` 
        (`id`, `round`, `bidder`, `item`, `value`,`multiplier`,`is_gold`,`by_father_type`) 
        VALUES 
        (NULL, '$round', '$user', '$item', '$value','$multiplier','$isGold','0');");  
   
    }
    $result['succeeded']='true';
    $result['message']=''; 

  }else{
    $result['succeeded']='false';
    $result['message']='you do not have enough money';  
  }
}else{
  $result['succeeded']='false';
  $result['message']='you can only bid on 6 items';  

}
 
 
function getRoundData(){
    $current_round=readRowFromSql("SELECT  `wheel_rounds`.`id`   FROM `wheel_rounds`    
    WHERE ADDTIME(`wheel_rounds`.`starts_at`, '00:00:42') > NOW() ORDER BY id DESC LIMIT 1",true);
    return $current_round['id'];
 }

 

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
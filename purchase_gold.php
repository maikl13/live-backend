<?php
include "config.php";
include "vip_manager.php";
  
$payment_id = $_GET['payment_id'];
$user = $_GET['user'];
$data=readRowFromSql("SELECT * FROM `coins_packages` WHERE `coins_packages`.`payment_id`='$payment_id'",true);
$gold=$data['value_in_coins'];
$realMoney=$data['value_in_real_money'];
$success= updateSql("INSERT INTO `wallet_transfers` (`id`, `value`, `wallet_type`, `reason`, `transfer_type`, `datetime`, `user`) VALUES (NULL, '$gold', 'g', 'purchase', 'deposit', CURRENT_TIMESTAMP, '$user');");
$result= updateSql("UPDATE `users` SET `gold` =gold+$gold WHERE `users`.`uid` = '$user';");
 
earnVipPoints($user,$realMoney); 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$chat_box =$_GET['chat_box'];
 
    $price= readRowFromSql("
SELECT  `chat_box`.`golds` FROM `chat_box` WHERE  `chat_box`.`id`='$chat_box'
 ", true)['golds'];


   $payed=false;
   $result=false;
   if($price!=0){
       $payed=payNow($uid,$price,'g');
   }

   if($price==0||$payed){
    $result = updateSql("INSERT INTO `users_chat_boxes` (`id`, `user`, `chat_box`, `purchase_date`) 
    VALUES (NULL, '$uid', '$chat_box', CURDATE());");
   }


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
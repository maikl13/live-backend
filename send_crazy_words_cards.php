<?php
include "config.php";
include "pay.php";

$receiver = $_GET['receiver'];
$sender = $_GET['sender'];
$type = $_GET['type'];
$room = $_GET['room'];


 $stock=readRowFromSql(" SELECT stock FROM `users_crazywords` WHERE `users_crazywords`.`user_uid`='$sender' AND `users_crazywords`.`crazyword`='$type' ", true)['stock'];

  if($stock==NULL){
      $stock=0;
  }
 if($stock>=1){
        $UPDATE_stock = updateSql("UPDATE `users_crazywords` SET `stock` = '0' WHERE `users_crazywords`.`user_uid`='sender' AND `users_crazywords`.`crazyword`='$type';");
          $result = updateSql("INSERT INTO `users_sent_crazy_words_cards`
  (`id`, `user`,`sender`, `type`, `room`, `count`, `done`, `datetime`) VALUES
  (NULL, '$receiver', '$sender', '$type', '$room', '3', '0', CURRENT_TIMESTAMP);");
   $resultToBeBack['succeeded']=true;
        $resultToBeBack['message']='sent successfully';
 }else{
        $one_crazyword_price=readRowFromSql("SELECT `crazy_words`.`golds` FROM `crazy_words` WHERE `crazy_words`.`id`=$crazyword", true)['golds'];
   $one_crazyword_price=get_price_after_store_discount($sender,$one_crazyword_price);
   
        if(payNow($sender,$one_crazyword_price,'g')){
             
                $result = updateSql("INSERT INTO `users_sent_crazy_words_cards`
  (`id`, `user`,`sender`, `type`, `room`, `count`, `done`, `datetime`) VALUES
  (NULL, '$receiver', '$sender', '$type', '$room', '3', '0', CURRENT_TIMESTAMP);");
         $resultToBeBack['succeeded']=true;
        $resultToBeBack['message']='sent successfully';
  }else{
        $resultToBeBack['succeeded']=false;
        $resultToBeBack['message']='not enogh golds';
  }
 }
  
  
 
   
   
  



echo json_encode($resultToBeBack, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
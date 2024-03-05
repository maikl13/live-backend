<?php
include "config.php";
include "pay.php";

$receiver = $_GET['receiver'];
$sender = $_GET['sender'];
$voice_changer = $_GET['voiceChanger'];
$room = $_GET['room'];


 $stock=readRowFromSql(" SELECT stock FROM `users_voice_changers` WHERE `users_voice_changers`.`user_uid`='$sender' AND `users_voice_changers`.`voice_changer`='$voice_changer' ", true)['stock'];

  if($stock==NULL){
      $stock=0;
  }
 if($stock>=1){
        $UPDATE_stock = updateSql("UPDATE `users_voice_changers` SET `stock` = '0' WHERE `users_voice_changers`.`user_uid`='sender' AND `users_voice_changers`.`voice_changer`='$voice_changer';");
          $result = updateSql("INSERT INTO `users_sent_voice_changers`
  (`id`, `user`,`sender`, `voice_changer`, `room`,  `datetime`) VALUES
  (NULL, '$receiver', '$sender', '$voice_changer', '$room',  CURRENT_TIMESTAMP);");
   $resultToBeBack['succeeded']=true;
        $resultToBeBack['message']='sent successfully';
 }else{
        $one_voice_changer_price=readRowFromSql("SELECT `voice_changer`.`price` FROM `voice_changer` WHERE `voice_changer`.`id`=$voice_changer", true)['price'];
   $one_voice_changer_price=get_price_after_store_discount($sender,$one_voice_changer_price);
   
        if(payNow($sender,$one_voice_changer_price,'g')){
             
                $result = updateSql("INSERT INTO `users_sent_voice_changers`
  (`id`, `user`,`sender`, `voice_changer`, `room`,  `datetime`) VALUES
  (NULL, '$receiver', '$sender', '$voice_changer', '$room',  CURRENT_TIMESTAMP);");
         $resultToBeBack['succeeded']=true;
        $resultToBeBack['message']='sent successfully';
  }else{
        $resultToBeBack['succeeded']=false;
        $resultToBeBack['message']='not enogh golds';
  }
 }
  
  
 
   
   
  



echo json_encode($resultToBeBack, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
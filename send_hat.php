<?php
include "config.php";
 include "pay.php";

 
$sender =$_GET['sender'];
 $hat =$_GET['hat'];
 $room =$_GET['room'];
 


 $receivers_uids =$_GET['receivers_uids'];
 $uidsArray=json_decode($receivers_uids);
 $one_hat_price=readRowFromSql("SELECT `hats`.`golds` FROM `hats`
 WHERE `hats`.`id`=$hat", true)['golds'];
  $one_hat_price=get_price_after_store_discount($uid,$one_hat_price);
 
 
  $receiversCount=COUNT($uidsArray);
 
  $stock=readRowFromSql(" SELECT stock FROM `users_hats` WHERE `users_hats`.`user_uid`='$sender' AND `users_hats`.`hat`='$hat' ", true)['stock'];

  if($stock==NULL){
      $stock=0;
  }
  

     if($stock>=$receiversCount){
      $remainStock=$stock-$receiversCount;
       $UPDATE_stock = updateSql("UPDATE `users_hats` SET `stock` = '$remainStock' WHERE `users_hats`.`user_uid`='sender' AND `users_hats`.`hat`='$hat';");
       foreach($uidsArray as $receiver){
      updateSql("INSERT INTO `users_sent_hats`
      (`id`, `sender`, `receiver`, `hat`, `room`, `datetime`) VALUES 
      (NULL, '$sender', '$receiver', '$hat', '$room', CURRENT_TIMESTAMP);");
           
       }
       $resultToBeBack['succeeded']=true;
        $resultToBeBack['message']='sent successfully';
       
       
  }else if($stock<$receiversCount){
         $remainReceiversCount=$receiversCount-$stock;
         $remainHatPrice=$one_hat_price*$remainReceiversCount;
          if(payNow($sender,$remainHatPrice,'g')){
             
              $UPDATE_stock = updateSql("UPDATE `users_hats` SET `stock` = '0' WHERE `users_hats`.`user_uid`='sender' AND `users_hats`.`hat`='$hat';");
           foreach($uidsArray as $receiver){
          updateSql("INSERT INTO `users_sent_hats`
         (`id`, `sender`, `receiver`, `hat`, `room`, `datetime`) VALUES 
         (NULL, '$sender', '$receiver', '$hat', '$room', CURRENT_TIMESTAMP);");   
          }
         $resultToBeBack['succeeded']=true;
        $resultToBeBack['message']='sent successfully';
  }else{
        $resultToBeBack['succeeded']=false;
        $resultToBeBack['message']='not enogh golds';
  }
 }
 
  
 
 
 

echo json_encode($resultToBeBack, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
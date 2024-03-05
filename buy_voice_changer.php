<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$voice_changer =$_GET['voice_changer'];
$count =$_GET['count'];




$one_voice_changer_price;


   $one_voice_changer_price=readRowFromSql("SELECT `crazy_words`.`golds` FROM `crazy_words` WHERE `crazy_words`.`id`=$voice_changer", true)['golds'];
   $one_voice_changer_price=get_price_after_store_discount($uid,$one_voice_changer_price);
 



$finalPrice=$one_voice_changer_price*$count;
        if(payNow($uid,$finalPrice,'g')){
            $getOldData=readRowFromSql("SELECT `users_voice_changers`.`id`,`users_voice_changers`.`stock` FROM `users_voice_changers` WHERE `users_voice_changers`.`user_uid`='$uid' AND `users_voice_changers`.`voice_changer`=$voice_changer", true); 
            if($getOldData!=null){
                $old_count_in_stock=$getOldData['stock'];
                $newCount=$old_count_in_stock+$count;
                 $old_id=$getOldData['id'];
                  $result = updateSql("UPDATE `users_voice_changers` SET `stock` = '$newCount' WHERE `users_voice_changers`.`id` = $old_id;");
                
            }else{
              
                    $result = updateSql("INSERT INTO `users_voice_changers` (`id`, `user_uid`, `voice_changer`, `stock`) VALUES (NULL, '$uid', '$voice_changer', '$count');");
                   
                   
            }
        
    echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
       }else{
      
           echo "false";
       }

?>
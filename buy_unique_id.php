<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$unique_id =$_GET['unique_id'];
$forRoom =$_GET['for_room'];
$price =$_GET['price'];
 
        if(payNow($uid,$price,'g')){
          $result = updateSql("DELETE FROM `users_unique_ids` WHERE `users_unique_ids`.`user` = '$uid' AND  `users_unique_ids`.`for_room`='$forRoom'");
           $result = updateSql("INSERT INTO `users_unique_ids` (`id`, `user`, `unique_id`, `datetime`, `for_room`) VALUES (NULL, '$uid', '$unique_id', CURRENT_TIMESTAMP, '$forRoom');");
  
    if($forRoom){
           $result = updateSql("UPDATE `rooms` SET `short_digital_id` = '$unique_id' WHERE `rooms`.`creator_uid`= '$uid'");
    }else{
           $result = updateSql("UPDATE `users` SET `short_digital_id` = '$unique_id' WHERE `users`.`uid` = '$uid';");
    }
      echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
       }else{
           echo "false";
       }

?>
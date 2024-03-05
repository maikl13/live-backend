<?php
include "config.php";

$blocker = $_GET['blocker'];
$blocked= $_GET['blocked'];
$block= $_GET['block'];

$result=false;
 $is_blocked = readRowFromSql("SELECT `blocked_users`.`id`
 FROM `blocked_users` WHERE `blocked_users`.`blocker`='$blocker'
 AND `blocked_users`.`blocked`='$blocked' ", true)['id'];
if($block){
 if($is_blocked==null){
       $result = updateSql("INSERT INTO `blocked_users` 
       (`id`, `blocker`, `blocked`, `datetime`) VALUES 
       (NULL, '$blocker', '$blocked', CURRENT_TIMESTAMP);");
  $result = updateSql("DELETE FROM `friend_requests` WHERE
(`friend_requests`.`sender_uid`='$blocker' 
AND `friend_requests`.`receiver_uid`='$blocked') OR
(`friend_requests`.`sender_uid`='$blocked' 
AND `friend_requests`.`receiver_uid`='$blocker')");     
   $result = updateSql("DELETE FROM `followers`
   WHERE
(`followers`.`follower_uid`='$blocker' 
AND `followers`.`followed_uid`='$blocked') OR
(`followers`.`follower_uid`='$blocked' 
AND `followers`.`followed_uid`='$blocker')"); 
 echo $result?1:0;
 }else{
     echo 0;
 } 
}else{
 $result = updateSql("DELETE FROM `blocked_users` WHERE `blocked_users`.`id` = $is_blocked");
 echo $result?1:0;
}

 
          


?>
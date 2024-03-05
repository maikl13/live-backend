<?php
include "leave_room_now.php";
 
 
$resenctOfflineUsers = readRowFromSql("
SELECT `users`.`uid` 
FROM `users`
WHERE `users`.`is_online` = 1 
AND TIMESTAMPDIFF(SECOND, `users`.`last_active`, NOW()) > 10;", false);

foreach($resenctOfflineUsers as $userOffline){
    $userOfflineUid=$userOffline['uid'];
    //set `is_online`=0
 
         
     updateSql("UPDATE `users` SET `is_online`=0,`last_active`=CURDATE() WHERE  `users`.`uid`='$userOfflineUid'");
     //leave room if they in one
 
     $room_id=readRowFromSql("SELECT  `room_id`  FROM `user_rooms` WHERE  `user_rooms`.`user_uid`='$userOfflineUid' AND  `user_rooms`.`is_online`='1'", true)['room_id'];
   leaveRoomNow($userOfflineUid,$room_id);
 
     //send in RTM to notify other members/no 
     
}


 
  
?>
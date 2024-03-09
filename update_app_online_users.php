<?php
include "leave_room_now.php";
 
 
$resenctOfflineUsers = readRowFromSql("
SELECT `users`.`id` , `users`.`uid` 
FROM `users`
WHERE
`users`.`is_online` = 1 
AND
TIMESTAMPDIFF(SECOND, `users`.`last_active`, NOW()) > 30;", false);


foreach($resenctOfflineUsers as $userOffline){
    $userOfflineUid=$userOffline['uid'];
    //set `is_online`=0
 
         
   updateSql("UPDATE `users` SET `is_online`=0 WHERE  `users`.`uid`='$userOfflineUid'");
     
   //leave room if they in one
 

    $rooms = readRowFromSql( "SELECT  `room_id`  FROM `user_rooms` WHERE  `user_rooms`.`user_uid`='$userOfflineUid' ", false);
    foreach($rooms as $room){
        $room_id = $room['room_id'];
  
        echo  "make user : ". $userOfflineUid . " Leave " . $room_id . "\r\n"        ;
        leaveRoomNow($userOfflineUid,$room_id);
        echo "\r\n"  ;
     }
    
 
     //send in RTM to notify other members/no 
     
}


 
  
?>
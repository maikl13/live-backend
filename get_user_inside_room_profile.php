<?php
include "config.php";


$user_uid =$_GET['user_uid'];
$room_id =$_GET['room_id'];
 
 

$userData = readRowFromSql("SELECT 
 
EXISTS (SELECT  `rooms_banned_from_chat_users`.`id` FROM `rooms_banned_from_chat_users` WHERE 
 `rooms_banned_from_chat_users`.`user`='$user_uid' AND  `rooms_banned_from_chat_users`.`room` ='$room_id') AS  banned_from_chat,
 
user_rooms.is_joined AS is_joined
FROM `user_rooms`
WHERE `user_rooms`.`user_uid`='$user_uid' AND user_rooms.room_id='$room_id' 
 
", true);

 $user_in_agency= readRowFromSql("SELECT `agency`.`id` as agency_id, `agency`.`name`  as agency_name, `agency`.`image`   as agency_image FROM `users`
INNER JOIN `agency` ON  `agency`.`id`= `users`.`agency_id`
WHERE `users`.`uid` = '$user_uid'", true);
if($user_in_agency!=null){
    
   
     $toBeReturned['agency']=$user_in_agency;
}
 
$toBeReturned['banned_from_chat']=$userData['banned_from_chat'];
 $toBeReturned['is_joined']=$userData['is_joined'];


  echo json_encode($toBeReturned, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
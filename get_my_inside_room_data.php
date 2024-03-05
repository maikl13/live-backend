<?php
include "config.php";


$user_uid =$_GET['user_uid'];
$room_id =$_GET['room_id'];
 
 $userData = readRowFromSql("SELECT 
 `vehicles`.`id` as vehicle_id,
  `vehicles`.`animated_image` as vehicle_animated_image,
  `vehicles`.`image` as vehicle_image,
 
EXISTS (SELECT  `rooms_banned_from_chat_users`.`id` FROM `rooms_banned_from_chat_users` WHERE 
 `rooms_banned_from_chat_users`.`user`='$user_uid' AND  `rooms_banned_from_chat_users`.`room` ='$room_id') AS  banned_from_chat,
 EXISTS (SELECT rooms_admins.id  FROM `rooms_admins` WHERE `rooms_admins`.`user`=`users`.`uid` AND `rooms_admins`.`room`='$room_id') AS is_admin,
user_rooms.is_joined AS is_joined,
user_rooms.following AS following,
`userInRoomLevelTotal`.`currentLevel` AS insideRoomLevel 
FROM `user_rooms`

INNER JOIN `users` on `users`.`uid`=`user_rooms`.`user_uid`
LEFT OUTER JOIN `vehicles` on `vehicles`.`id`=`users`.`vehicle`
LEFT OUTER  JOIN `users_vehicles`ON `users_vehicles`.`vehicle` =`vehicles`.`id`
AND `users_vehicles`.`user`=`users`.`uid`
 AND CURDATE()< DATE_ADD(`users_vehicles`.`purchase_date`, INTERVAL 30 DAY) 



 
 LEFT OUTER JOIN `userInRoomLevelTotal`  ON  `userInRoomLevelTotal`.`user`=`users`.`uid`
 


WHERE `user_rooms`.`user_uid`='$user_uid' AND user_rooms.room_id='$room_id' 
GROUP BY user_rooms.id
", true);




 $userCrazyWords = readRowFromSql("SELECT * FROM `users_sent_crazy_words_cards` WHERE `users_sent_crazy_words_cards`.`user`='$user_uid'
AND `users_sent_crazy_words_cards`.`room`='$room_id' AND `users_sent_crazy_words_cards`.`done`!=`users_sent_crazy_words_cards`.`count`
ORDER BY `users_sent_crazy_words_cards`.`datetime` DESC", false);










$toBeReturned['user_crazy_words']=$userCrazyWords;
$toBeReturned['insideRoomLevel']=$userData['insideRoomLevel'];
$toBeReturned['is_joined']=$userData['is_joined'];
$toBeReturned['following']=$userData['following'];
$toBeReturned['is_admin']=$userData['is_admin'];
$toBeReturned['banned_from_chat']=$userData['banned_from_chat'];
if($userData['vehicle_id']!=null){
    $vehicle_in_room['id']=$userData['vehicle_id'];
$vehicle_in_room['image']=$userData['vehicle_image'];
$vehicle_in_room['animated_image']=$userData['vehicle_animated_image'];
$toBeReturned['vehicle_in_room']=$vehicle_in_room;

 
}



  echo json_encode($toBeReturned, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
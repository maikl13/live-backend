<?php
include "config.php";


$room_id =$_GET['room_id'];



$result = readRowFromSql("
SELECT  
users.id,
users.uid,
users.full_name,
users.profile_pic,
users.level,
users.gender,
users.current_premium_subscription,
users.current_vip_subscription,
 `user_rooms`.`is_joined`  ,
 CASE WHEN CURDATE() =  DATE_FORMAT(user_rooms.enter_datetime, '%Y-%m-%d')
 THEN 1 ELSE 0 END as active_today,
EXISTS (SELECT rooms_admins.id  FROM `rooms_admins` WHERE `rooms_admins`.`user`=`users`.`uid` AND `rooms_admins`.`room`='$room_id') AS is_admin
FROM `users`   
INNER JOIN `user_rooms` ON  `user_rooms`.`user_uid`=`users`.`uid` 
 
 
WHERE  `user_rooms`.`is_joined`  =1  AND `user_rooms`.`room_id`='$room_id'
GROUP BY users.id ORDER BY user_rooms.enter_datetime
", false);
 



echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
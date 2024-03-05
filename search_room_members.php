<?php
include "config.php";





$user_uid = $_GET['user_uid'];
$room_id = $_GET['room_id'];
$search_word = $_GET['search_word'];
 
  
   $results = readRowFromSql("  
  SELECT  
users.id,
users.uid,
users.full_name,
users.profile_pic,
users.level,
users.gender,
users.current_premium_subscription,

 CASE WHEN CURDATE() =  DATE_FORMAT(user_rooms.enter_datetime, '%Y-%m-%d')
 THEN 1 ELSE 0 END as active_today,
EXISTS (SELECT rooms_admins.id  FROM `rooms_admins` WHERE `rooms_admins`.`user`=`users`.`uid` AND `rooms_admins`.`room`='2') AS is_admin,
 
 EXISTS (SELECT users_vip_subscriptions.subscription_id  FROM `users_vip_subscriptions` WHERE `users_vip_subscriptions`.`user_uid`=`users`.`uid`) AS is_vip,
users_vip_subscriptions.subscription_id AS vip_subscription_id
FROM `users`   
INNER JOIN `user_rooms` ON  `user_rooms`.`user_uid`=`users`.`uid` 
 
LEFT OUTER JOIN users_vip_subscriptions ON `users_vip_subscriptions`.`user_uid`=`users`.`uid`
 
    WHERE ( users.full_name   LIKE '%$search_word%'||users.short_digital_id   LIKE '%$search_word%')AND(
      `user_rooms`.`is_joined` =1 
    )AND (`user_rooms`.`room_id`='$room_id')
GROUP BY  users.uid", false);

 


echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
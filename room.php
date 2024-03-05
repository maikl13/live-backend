<?php
include "config.php";


$room_id =$_GET['room'];



$result = readRowFromSql(" SELECT 
users.id,
users.uid,
users.full_name,
users.profile_pic,
users.level,
users.gender,
EXISTS (SELECT users_premium_subscriptions.subscription_id  FROM `users_premium_subscriptions` WHERE `users_premium_subscriptions`.`user_uid`=`users`.`uid`) AS is_premium,
users_premium_subscriptions.subscription_id AS premium_subscription_id,
 EXISTS (SELECT users_vip_subscriptions.subscription_id  FROM `users_vip_subscriptions` WHERE `users_vip_subscriptions`.`user_uid`=`users`.`uid`) AS is_vip,
users_vip_subscriptions.subscription_id AS vip_subscription_id

FROM `room_mic_application` 

INNER JOIN users ON users.uid=room_mic_application.user
LEFT OUTER JOIN users_premium_subscriptions ON `users_premium_subscriptions`.`user_uid`=`users`.`uid`
LEFT OUTER JOIN users_vip_subscriptions ON `users_vip_subscriptions`.`user_uid`=`users`.`uid`
WHERE room_mic_application.room ='$room_id'
", false);
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
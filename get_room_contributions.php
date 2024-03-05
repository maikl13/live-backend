<?php
include "config.php";



$user_uid =$_GET['user_uid'];
$room_id =$_GET['room_id'];
 
$days =$_GET['days'];
$timeCondition='';
 if($days=='1'){
     $timeCondition="CURDATE() =  DATE_FORMAT(users_gifts.send_datetime, '%Y-%m-%d')"; 
 }else  if($days=='7'){
     $timeCondition="CURDATE() <= date_add(DATE_FORMAT(users_gifts.send_datetime, '%Y-%m-%d') ,interval 7 day) "; 
 }

$result = readRowFromSql("SELECT
users.id,
users.uid,
users.full_name,
users.profile_pic,
users.level,
users.gender,
users.current_premium_subscription, 
 users.current_vip_subscription, 
 
EXISTS (SELECT rooms_admins.id  FROM `rooms_admins` WHERE `rooms_admins`.`user`=`users`.`uid` AND `rooms_admins`.`room`='$room_id') AS is_admin,

SUM(gifts.value)*users_gifts.count  as contribution FROM    user_rooms
INNER JOIN users ON user_rooms.user_uid=users.uid 
INNER JOIN users_gifts ON users_gifts.room_id= user_rooms.room_id and users_gifts.sender_uid=users.uid
INNER JOIN gifts ON gifts.id= users_gifts.gift_id  AND gifts.currency_type='GOLD'
WHERE user_rooms.room_id='$room_id' 
AND $timeCondition
GROUP BY users.uid 
ORDER BY contribution DESC LIMIT 10
 ", false);
 

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
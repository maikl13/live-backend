<?php
include "config.php";


$room_id =$_GET['room_id'];



$result = readRowFromSql(" SELECT 
users.id,
users.uid,
users.full_name,
users.profile_pic,
users.level,
users.gender,
users.current_premium_subscription,
 users.current_vip_subscription
FROM `room_mic_application` 
INNER JOIN users ON users.uid=room_mic_application.user
WHERE room_mic_application.room ='$room_id'
", false);
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
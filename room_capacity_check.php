<?php
include "config.php";

$room=$_GET['room'];
$user=$_GET['user'];

$room_data = readRowFromSql(" 
SELECT 
 room_upgrade_types.room_capacity ,
 COUNT(DISTINCT user_rooms.id) as onlineUsersCount
 FROM `rooms`  
INNER JOIN room_upgrade_types ON room_upgrade_types.id= `rooms`.`room_grade`
LEFT OUTER JOIN user_rooms ON user_rooms.room_id= `rooms`.`id` AND 
user_rooms.is_online =1
WHERE  `rooms`.`id`='$room'", true);
$onlineUsersCount=$room_data['onlineUsersCount'];
$room_capacity=$room_data['room_capacity'];
if($onlineUsersCount<$room_capacity){
    $result= true;
}else{
    $result= false;
}

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
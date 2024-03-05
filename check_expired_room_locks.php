 <?php
include "config.php";
 
$expires_today = readRowFromSql("SELECT rooms_locks.id as room_lock_id, rooms_locks.room as room_id
FROM `rooms`
LEFT OUTER JOIN `rooms_locks` ON  `rooms_locks`.`room`=`rooms`.`id`AND  `rooms_locks`.`expired`=0
LEFT OUTER JOIN `room_lock_packages_pricing` ON 
`room_lock_packages_pricing`.`id`=`rooms_locks`.`lock_package`

WHERE  CURDATE()> DATE_ADD(`rooms_locks`.`purchase_date`, INTERVAL `room_lock_packages_pricing`.`availability_duration_in_months` MONTH) "
, false) ;
 
foreach($expires_today as $expires_today_item){
$room_id=$expires_today_item['room_id'];
$room_lock_id=$expires_today_item['room_lock_id'];
 $result = updateSql("UPDATE  rooms_locks 
SET rooms_locks.expired=1
WHERE rooms_locks.room ='$room_id' AND 
rooms_locks.id='$room_lock_id'");
}
$room_have_no_days_left = readRowFromSql("SELECT DISTINCT rl1.room
FROM rooms_locks rl1
INNER JOIN rooms ON rooms.id = rl1.room AND rooms.enter_lock IS NOT NULL
WHERE NOT EXISTS (
    SELECT 1
    FROM rooms_locks rl2
    WHERE rl2.room = rl1.room AND rl2.expired = 0
)
GROUP BY rl1.room
"
, false) ;
 
foreach($room_have_no_days_left as $room_have_no_days_left_item){
    $room=$room_have_no_days_left_item['room'];
     $result = updateSql("UPDATE `rooms` SET `enter_lock` = NULL
WHERE  `rooms`.`id`='$room'");
}
//vehicle
$expires_today = readRowFromSql("SELECT users_vehicles.id as user_vehicle_id, users_vehicles.vehicle as vehicle_id
FROM `vehicles`
LEFT OUTER JOIN `users_vehicles` ON  `users_vehicles`.`vehicle`=`vehicles`.`id`AND  `users_vehicles`.`expired`=0
WHERE  CURDATE()> DATE_ADD(`users_vehicles`.`purchase_date`, INTERVAL 30 DAY) "
, false) ;
 foreach($expires_today as $expires_today_item){
$user_vehicle_id=$expires_today_item['user_vehicle_id'];
 $result = updateSql("UPDATE  users_vehicles 
SET users_vehicles.expired=1
users_vehicles.id='$user_vehicle_id'");
}
 
$users_have_no_vehicle_days_left = readRowFromSql("SELECT DISTINCT uv1.user
FROM users_vehicles uv1
INNER JOIN users u ON u.id = uv1.user AND u.vehicle IS NOT NULL
WHERE NOT EXISTS (
    SELECT 1
    FROM users_vehicles uv2
    WHERE uv2.user = uv1.user AND uv2.expired = 0
)
GROUP BY uv1.user;"
, false) ; 
foreach($users_have_no_vehicle_days_left as $users_have_no_vehicle_days_left_item){
    $user=$users_have_no_vehicle_days_left_item['user'];
     $result = updateSql("UPDATE `users` SET `vehicle` = NULL
WHERE  `users`.`uid`='$user'");
}
?>
 

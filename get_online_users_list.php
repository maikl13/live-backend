<?php
include "config.php";


$room_id =$_GET['room'];
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
$offset = ($page - 1) * $limit;

$paginationCode="LIMIT $limit OFFSET $offset";



$list = readRowFromSql("SELECT 
`vehicles`.`id` as vehicle_id,
  `vehicles`.`animated_image` as vehicle_animated_image,
  `vehicles`.`image` as vehicle_image,
user_rooms.is_joined AS is_joined,
users.id,
users.uid,
users.full_name,
users.profile_pic,
users.level,
users.gender,
users.current_premium_subscription,
users.current_vip_subscription,
 CASE WHEN users_unlocked_frames.id IS NOT NULL || frames.limited_days IS NULL
 THEN    frames.icon ELSE NULL END as frame_icon ,
 
 CASE WHEN users_unlocked_frames.id IS NOT NULL || frames.limited_days IS NULL
 THEN    frames.padding ELSE NULL END as frame_padding ,
EXISTS (SELECT rooms_admins.id  FROM `rooms_admins` WHERE `rooms_admins`.`user`=`users`.`uid` AND `rooms_admins`.`room`='$room_id') AS is_admin


FROM `user_rooms` 
INNER JOIN `users` ON `users`.`uid` =`user_rooms`.`user_uid`
LEFT OUTER JOIN `vehicles` on `vehicles`.`id`=`users`.`vehicle`
 
 
 INNER JOIN frames  ON users.used_frame = frames.id  
  LEFT OUTER JOIN users_unlocked_frames  ON
users_unlocked_frames.frame=frames.id AND users_unlocked_frames.user=users.uid AND
CURDATE() <= date_add(`users_unlocked_frames`.`datetime` ,interval frames.limited_days day)
    
WHERE  `user_rooms`.`room_id`='$room_id' AND user_rooms.is_online=1
GROUP BY users.id
ORDER BY current_premium_subscription  AND current_vip_subscription DESC

$paginationCode
", false);
$result=array();
foreach($list as $item){
    if($item['vehicle_id']!=null){
    $vehicle_in_room['id']=$item['vehicle_id'];
$vehicle_in_room['image']=$item['vehicle_image'];
$vehicle_in_room['animated_image']=$item['vehicle_animated_image'];
    $item['vehicle_in_room']=$vehicle_in_room;
   
}
  unset($item['vehicle_id']);
     unset($item['vehicle_animated_image']);
      unset($item['vehicle_image']);
    $result[]=$item;
}
$onlineGuestsUsersCount= readRowFromSql("SELECT COUNT(DISTINCT rooms_online_guests_count.id) as onlineGuestsUsersCount 
FROM `rooms_online_guests_count` WHERE  `rooms_online_guests_count`.`room`='$room_id'", true)['onlineGuestsUsersCount'];
$notJuestsCount= readRowFromSql("  SELECT 
COUNT(DISTINCT user_rooms.id) as notJuestsCount
FROM `user_rooms` 
WHERE  `user_rooms`.`room_id`='$room_id' AND user_rooms.is_online=1", true)['notJuestsCount'];
$totalOnlineUsersCount=$notJuestsCount+$onlineGuestsUsersCount;
$finalResult['users']=$result;
$finalResult['totalOnlineUsersCount']=$totalOnlineUsersCount;
$finalResult['onlineGuestsUsersCount']=$onlineGuestsUsersCount;

echo json_encode($finalResult, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
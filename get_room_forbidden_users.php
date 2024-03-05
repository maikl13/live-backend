


<?php
include "config.php";



$user_uid =$_GET['user_uid'];
$room_id =$_GET['room_id'];
  

$list = readRowFromSql("SELECT  `rooms_forbidden_users`.*,
 
forbidden_user.full_name as user_full_name,
forbidden_user.profile_pic as user_profile_pic,
forbidden_user.level as user_level,
forbidden_user.short_digital_id as short_digital_id,
forbidden_user.current_premium_subscription,
forbidden_user.current_vip_subscription,
user_rooms.is_joined AS is_joined,
admin.full_name as admin_name
FROM `rooms_forbidden_users`
INNER JOIN `users` admin ON  admin.`uid`=`rooms_forbidden_users`.`admin`
INNER JOIN `users` forbidden_user ON  forbidden_user.`uid`=`rooms_forbidden_users`.`user`
INNER JOIN `user_rooms` on  forbidden_user.`uid`=`user_rooms`.`user_uid` AND `user_rooms`.room_id = `rooms_forbidden_users`.`room`
WHERE `rooms_forbidden_users`.`room`='$room_id'
GROUP BY rooms_forbidden_users.user
 ", false);
 
$result=array(); 
foreach($list as $item){
    $formatedItem;
    $user["full_name"]=$item["user_full_name"];
    $user;
$user["level"]=$item["user_level"];
$user["profile_pic"]=$item["user_profile_pic"];
$user["current_premium_subscription"]=$item["current_premium_subscription"];
 
$user["uid"]=$item["user"];
$user["is_joined"]=$item["is_joined"];
$formatedItem['user']=$user;
$formatedItem['admin_name']=$item['admin_name'];
$formatedItem['admin_uid']=$item['admin'];
$formatedItem['permanently']=$item['permanently'];
$result[]=$formatedItem;
}
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
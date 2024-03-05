<?php
include "config.php";
include "rooms_manager.php";


$user_uid =$_GET['user_uid'];
$room_id =$_GET['room_id'];


$neededRoom = readRowFromSql("

SELECT
me.`following` as following,
`rooms`.`id`,
`rooms`.`image`,
`rooms`.`title`, 
`rooms`.`description`,
`hashtags`.`id` as hashtag_id, `hashtags`.`title` as hashtag_title,
`countries`.`id` as country_id, `countries`.`name` as country_name, `countries`.`flag` as country_flag,
`rooms`.`country`,
COUNT( members.`id`) AS members_count,
`room_upgrade_types`.`room_capacity`,
`rooms`.`creator_uid`, 
`users`.`language_code`,
`rooms`.`short_digital_id`, 
`rooms`.`channel_id`,
`rooms`.`number_of_mics`,
`rooms`.`channel_token`, 
`rooms`.`theme`,
`rooms`.`theme_type`,
`rooms`.`rtm_channel_id`,
`rooms`.`membership_fee`,
`rooms`.`room_level`,
`rooms`.`mic_application_is_turned_on`,
`rooms`.`mic_for_members_only`,
`rooms`.`allow_guests_to_enter`,
 rooms.allow_admins_to_lock_or_unlock_the_mic
 ,rooms.allow_admins_to_turn_on_or_off_the_mic_application,
 rooms.allow_admins_to_manage_events,
`rooms`.`enter_lock`
FROM `rooms`
LEFT OUTER JOIN `user_rooms` me ON me.`room_id`=`rooms`.`id` AND me.`user_uid`='$user_uid' AND me.`following`=1
LEFT OUTER JOIN `user_rooms` members ON members.`room_id`=`rooms`.`id` AND members.is_online=1
INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
INNER JOIN `users`  ON users.`uid`=`rooms`.`creator_uid`  
LEFT OUTER JOIN `room_upgrade_types`  ON room_upgrade_types.`id`=`rooms`.`room_grade`  
  
 

WHERE `rooms`.`id`='$room_id' 
 ", true);


$result=getRoomExtraData($neededRoom);
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
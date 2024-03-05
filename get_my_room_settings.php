<?php
include "config.php";


$user_uid =$_GET['user_uid'];
 
 $result = readRowFromSql("SELECT rooms.title,rooms.image,rooms.description ,rooms.membership_fee ,rooms.room_level,
 rooms.number_of_mics,
 rooms.allow_admins_to_lock_or_unlock_the_mic
 ,rooms.allow_admins_to_turn_on_or_off_the_mic_application,
 rooms.allow_admins_to_manage_events,
 rooms.allow_guests_to_enter,rooms.mic_for_members_only,
 
 `hashtags`.`id` as hashtag_id, `hashtags`.`title` as hashtag_title,
  CASE
            WHEN 
            TIMESTAMPDIFF(MONTH,   `rooms_locks`.`purchase_date`,CURRENT_TIMESTAMP)
            
     < `room_lock_packages_pricing`.`availability_duration_in_months`
               THEN 1
               ELSE 0
       END as available_lock_package,
 `rooms`.`enter_lock`,
 `room_lock_packages_pricing`.`availability_duration_in_months` as room_lock_availability_duration_in_months,
 `rooms_locks`.`purchase_date`as  room_lock_purchase_date
FROM `rooms`
INNER JOIN `hashtags` ON `hashtags`.`id` = rooms.`hashtag`
LEFT OUTER JOIN `rooms_locks` ON  `rooms_locks`.`room`=`rooms`.`id`
LEFT OUTER JOIN `room_lock_packages_pricing` ON 
`room_lock_packages_pricing`.`id`=`rooms_locks`.`lock_package`
WHERE rooms.creator_uid='$user_uid'

", true);
 
 $hashtag['id']=$result['hashtag_id'];
$hashtag['title']=$result['hashtag_title'];
$result['hashtag']=$hashtag;
unset($result['hashtag_id']);
unset($result['hashtag_title']);

  echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
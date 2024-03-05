<?php
include "config.php";
include "rooms_manager.php";



$result       = array();
$my_uid =$_GET['my_uid'];
$user_uid =$_GET['required_user_uid'];



        

  $joined = readRowFromSql("
SELECT
`rooms`.`id`,
`rooms`.`image`,
`rooms`.`title`, 
`rooms`.`description`,
`hashtags`.`id` as hashtag_id, `hashtags`.`title` as hashtag_title,
`countries`.`id` as country_id, `countries`.`name` as country_name, `countries`.`flag` as country_flag,
`rooms`.`country`,
COUNT( user_rooms2.`id`) AS members_count
FROM `rooms`
INNER JOIN `user_rooms` user_rooms1 ON `rooms`.`id`=user_rooms1.`room_id` AND user_rooms1.`user_uid`='$user_uid'
AND user_rooms1.`is_joined`=1
RIGHT OUTER JOIN `user_rooms` user_rooms2 ON user_rooms2.`room_id`=`rooms`.`id`
INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
WHERE `rooms`.`creator_uid` !='$user_uid' 
GROUP BY `rooms`.`id`
", false);


$result=getRoomsEssentialData($joined);
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
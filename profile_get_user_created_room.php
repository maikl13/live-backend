<?php
include "config.php";
include "rooms_manager.php";



$result       = array();
$my_uid =$_GET['my_uid'];
$user_uid =$_GET['required_user_uid'];





        

    $created = readRowFromSql("SELECT
`rooms`.`id`,
`rooms`.`image`,
`rooms`.`title`, 
`rooms`.`description`,
`hashtags`.`id` as hashtag_id, `hashtags`.`title` as hashtag_title,
`countries`.`id` as country_id, `countries`.`name` as country_name, `countries`.`flag` as country_flag,
`rooms`.`country`,
COUNT( members.`id`) AS members_count
FROM `rooms`
LEFT OUTER JOIN `user_rooms` members ON members.`room_id`=`rooms`.`id` 
INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
WHERE `rooms`.`creator_uid` ='$user_uid'
GROUP BY `rooms`.`id`
 ", false);


//echo json_encode($created, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
$result1=getRoomsEssentialData($created);
$result=$result1[0];
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
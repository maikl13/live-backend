<?php
include "config.php";
include "rooms_manager.php";





$user_uid = $_GET['user_uid'];
 
   $neededRooms = readRowFromSql(" SELECT 
COUNT(viewed_rooms_search_results.id) as views_count,
me.`following` as following,
`rooms`.`id`,
`rooms`.`image`,
`rooms`.`title`, 
`rooms`.`description`,
`hashtags`.`id` as hashtag_id, `hashtags`.`title` as hashtag_title,
`countries`.`id` as country_id, `countries`.`name` as country_name, `countries`.`flag` as country_flag,
`rooms`.`country`,
COUNT( members.`id`) AS members_count
FROM `viewed_rooms_search_results`
INNER JOIN rooms on rooms.id = viewed_rooms_search_results.room_id
LEFT OUTER JOIN `user_rooms` me ON me.`room_id`=`rooms`.`id` AND me.`user_uid`='$user_uid' AND me.`following`=1
LEFT OUTER JOIN `user_rooms` members ON members.`room_id`=`rooms`.`id` 
INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
GROUP BY viewed_rooms_search_results.room_id
ORDER BY views_count DESC
", false);

 
 $results=getRoomsEssentialData($neededRooms);

echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
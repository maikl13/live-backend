<?php
include "config.php";
include "rooms_manager.php";





$user_uid = $_GET['user_uid'];
$search_word = $_GET['search_word'];
 
   $neededRooms = readRowFromSql("
SELECT
me.`following` as following,
`rooms`.`id`,
`rooms`.`short_digital_id`,
`rooms`.`image`,
`rooms`.`title`, 
`rooms`.`description`,
`hashtags`.`id` as hashtag_id, `hashtags`.`title` as hashtag_title,
`countries`.`id` as country_id, `countries`.`name` as country_name, `countries`.`flag` as country_flag,
`rooms`.`country`,
COUNT( members.`id`) AS members_count
FROM `rooms`
LEFT OUTER JOIN `user_rooms` me ON me.`room_id`=`rooms`.`id` AND me.`user_uid`='$user_uid' AND me.`following`=1
LEFT OUTER JOIN `user_rooms` members ON members.`room_id`=`rooms`.`id` 
INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
WHERE `rooms`.`title` ='$search_word'
GROUP BY `rooms`.`id` 
", false);
$results=getRoomsEssentialData($neededRooms);

  $add_to_history = updateSql("INSERT INTO `search_history` (`id`, `searcher_uid`, `word`,`type`) VALUES (NULL, '$user_uid', '$search_word','rooms');");

echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
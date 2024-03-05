<?php
include "config.php";
include "rooms_manager.php";



$result       = array();
$neededRooms=array();
// Sanitize input and handle potential errors
$type = isset($_GET['type']) ? $_GET['type'] : 'ALL';
$user_uid = isset($_GET['user_uid']) ? $_GET['user_uid'] : '';

// Pagination parameters
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limit = isset($_GET['limit']) ? max(1, (int)$_GET['limit']) : 10;
$offset = ($page - 1) * $limit;

$paginationCode="LIMIT $limit OFFSET $offset";
switch ($type){
    case "ALL":
   
        $selectChat="
        SELECT
            me.`following` as following,
            `rooms`.`id`,
            `rooms`.`image`,
            `rooms`.`title`, 
            `rooms`.`description`,
            `hashtags`.`id` as hashtag_id,
            `hashtags`.`title` as hashtag_title,
            `countries`.`id` as country_id,
            `countries`.`name` as country_name,
            `countries`.`flag` as country_flag,
            `rooms`.`country`,
            COUNT(members.`id`) AS members_count
        FROM `rooms`
        LEFT OUTER JOIN `user_rooms` me ON me.`room_id` = `rooms`.`id` AND me.`user_uid` = '$user_uid' AND me.`following` = 1
        LEFT OUTER JOIN `user_rooms` members ON members.`room_id` = `rooms`.`id` AND members.is_online = 1
        INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
        INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
        WHERE `rooms`.`id` NOT IN (
            SELECT
                `rooms`.`id`
            FROM `rooms`
            INNER JOIN counter ON counter.previous_winner = rooms.creator_uid
            INNER JOIN room_occupier_on_enter ON room_occupier_on_enter.room_id = rooms.id
            GROUP BY `rooms`.`id`
        )
        GROUP BY `rooms`.`id`
        $paginationCode
         ";
        // echo $selectChat;
        $rooms = readRowFromSql($selectChat, false);
          $neededRooms=$rooms;
    
  
 
    break;
        case "PINNED":
          $selectCode  ="
            SELECT
            me.`following` as following,
            `rooms`.`id`,
            `rooms`.`image`,
            `rooms`.`title`, 
            `rooms`.`description`,
            `hashtags`.`id` as hashtag_id, `hashtags`.`title` as hashtag_title,
            `countries`.`id` as country_id, `countries`.`name` as country_name, `countries`.`flag` as country_flag,
            `rooms`.`country`,
            COUNT( members.`id`) AS members_count
            FROM `rooms`
            LEFT OUTER JOIN `user_rooms` me ON me.`room_id`=`rooms`.`id` AND me.`user_uid`='$user_uid' AND me.`following`=1
            LEFT OUTER JOIN `user_rooms` members ON members.`room_id`=`rooms`.`id` AND members.is_online=1
            INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
            INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
            INNER JOIN counter ON counter.previous_winner=rooms.creator_uid
            INNER JOIN room_occupier_on_enter ON room_occupier_on_enter.room_id=rooms.id
            GROUP BY `rooms`.`id`
             ";
       //   echo $selectCode;
    $neededRooms = readRowFromSql($selectCode, false);
break;
        case "POPULAR":
    $neededRooms = readRowFromSql("
SELECT
`rooms`.`id`,
`rooms`.`image`,
`rooms`.`title`, 
`rooms`.`description`,
`hashtags`.`id` as hashtag_id, `hashtags`.`title` as hashtag_title,
`countries`.`id` as country_id, `countries`.`name` as country_name, `countries`.`flag` as country_flag,
`rooms`.`country`,
COUNT( `user_rooms`.`id`) AS members_count
FROM `rooms`
LEFT OUTER JOIN `user_rooms`  ON `user_rooms`.`room_id`=`rooms`.`id` AND user_rooms.is_online=1
INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
GROUP BY `rooms`.`id`

ORDER BY members_count DESC
$paginationCode
 ", false);
    break;
    case "RECENT":
        $code1="
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
INNER JOIN `user_rooms` user_rooms1  ON `rooms`.`id`=user_rooms1.`room_id` 
AND user_rooms1.`user_uid`='$user_uid'
LEFT OUTER JOIN `user_rooms` user_rooms2 ON user_rooms2.`room_id`=`rooms`.`id`  AND user_rooms2.is_online=1
INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
GROUP BY `rooms`.`id`
ORDER BY user_rooms1.`enter_datetime` DESC
$paginationCode
";
 
    $neededRooms = readRowFromSql($code1, false);
    break;
    
      case "FOLLOWED":
    $neededRooms = readRowFromSql("
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
AND user_rooms1.`following`=1
LEFT OUTER JOIN `user_rooms` user_rooms2 ON user_rooms2.`room_id`=`rooms`.`id` AND user_rooms2.is_online=1
INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
GROUP BY `rooms`.`id`
$paginationCode
", false);
    break;
        //copy from popular
         case "HOT":
    $neededRooms = readRowFromSql("
SELECT
`rooms`.`id`,
`rooms`.`image`,
`rooms`.`title`, 
`rooms`.`description`,
`hashtags`.`id` as hashtag_id, `hashtags`.`title` as hashtag_title,
`countries`.`id` as country_id, `countries`.`name` as country_name, `countries`.`flag` as country_flag,
`rooms`.`country`,
COUNT( `user_rooms`.`id`) AS members_count
FROM `rooms`
LEFT OUTER JOIN `user_rooms`  ON `user_rooms`.`room_id`=`rooms`.`id`  AND user_rooms.is_online=1
INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
GROUP BY `rooms`.`id`

ORDER BY members_count DESC
$paginationCode
 ", false);
    break;
   
        //end
        case "JOINED":
    $neededRooms = readRowFromSql("
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
RIGHT OUTER JOIN `user_rooms` user_rooms2 ON user_rooms2.`room_id`=`rooms`.`id`  AND user_rooms2.is_online=1
INNER JOIN `countries` ON `countries`.`id` = `rooms`.`country`
INNER JOIN `hashtags` ON `hashtags`.`id` = `rooms`.`hashtag`
GROUP BY `rooms`.`id`
$paginationCode
", false);
    break;
        
}
 
$result=getRoomsEssentialData($neededRooms);

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
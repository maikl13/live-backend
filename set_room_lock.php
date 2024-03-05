<?php
include "config.php";
include "rooms_manager.php";


$user_uid =$_GET['user_uid'];
$room_id =$_GET['room_id'];
$passcode =$_GET['passcode'];

$available_lock_package = readRowFromSql("
SELECT rooms_locks.id  
FROM `rooms`
INNER  JOIN `rooms_locks` ON  `rooms_locks`.`room`=`rooms`.`id`AND  `rooms_locks`.`expired`=0
INNER JOIN `room_lock_packages_pricing` ON 
`room_lock_packages_pricing`.`id`=`rooms_locks`.`lock_package`
WHERE rooms.id='$room'
 ", true)['id'];


if($available_lock_package!=null){
      $result = updateSql("UPDATE `rooms` SET `enter_lock` = '$passcode' WHERE `rooms`.`creator_uid` = '$user_uid';");
}

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
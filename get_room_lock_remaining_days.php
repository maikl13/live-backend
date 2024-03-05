<?php
include "config.php";



$user_uid =$_GET['uid'];
 


$remaining = readRowFromSql("
SELECT
 
SUM(   ( `room_lock_packages_pricing`.`availability_duration_in_months`*30)- TIMESTAMPDIFF(DAY,   `rooms_locks`.`purchase_date`,CURRENT_TIMESTAMP))
           as remaining
FROM `rooms`
LEFT OUTER JOIN `rooms_locks` ON  `rooms_locks`.`room`=`rooms`.`id`
LEFT OUTER JOIN `room_lock_packages_pricing` ON 
`room_lock_packages_pricing`.`id`=`rooms_locks`.`lock_package`

WHERE `rooms`.`creator_uid`='$user_uid' 
 AND CURDATE()< DATE_ADD(`rooms_locks`.`purchase_date`, INTERVAL `room_lock_packages_pricing`.`availability_duration_in_months` MONTH) 
     

 ", true)['remaining'];

$result=0;
 if($remaining>=0){
    $result= $remaining;
 }

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
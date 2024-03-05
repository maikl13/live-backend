<?php
include "config.php";

$uid =$_GET['uid'];
 
$result= readRowFromSql("SELECT frames.*,
 CASE
 WHEN 
( frames.limited_days IS NOT NULL AND
 CURDATE()<  DATE_ADD( `users_unlocked_frames`.`datetime`,
                      INTERVAL  frames.limited_days DAY ) AND
             `users_unlocked_frames`.`user`  IS NOT NULL )
            OR ( frames.limited_days IS NULL AND
             `users_unlocked_frames`.`user`  IS NOT NULL )
               THEN 1
               ELSE 0
 END as owned,
 CASE
 WHEN 
 `users`.`used_frame`=`frames`.`id`
 AND
 `users`.`uid`  IS NOT NULL 
               THEN 1
               ELSE 0
       END as selected
FROM `frames`
LEFT OUTER JOIN users_unlocked_frames  ON `users_unlocked_frames`.`frame`=frames.`id` AND `users_unlocked_frames`.`user` ='$uid'
LEFT OUTER JOIN `users` ON `users`.`uid`=users_unlocked_frames.user
 
GROUP BY frames.id


 "
, false);
 
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";





$user_uid = $_GET['user_uid'];
 
 
   $result = readRowFromSql(" SELECT 
   users.uid,
 users.gender,
 users.bio,
 users.full_name,
 users.profile_pic
  FROM `users` 
INNER JOIN followers ON users.uid=followers.followed_uid
WHERE users.uid != '$user_uid' 
GROUP BY `users`.`id`
ORDER BY COUNT(followers.id) DESC

LIMIT 10
", false);


    

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
<?php
include "config.php";





$user_uid = $_GET['user_uid'];
 

   $friends = readRowFromSql(" 
 SELECT 
   users.uid,
 users.gender,
 users.bio,
 users.full_name,
 users.profile_pic
  FROM `friend_requests` 
  INNER JOIN `users`
  ON
  users.uid =(
  CASE
    WHEN friend_requests.sender_uid ='$user_uid' THEN  friend_requests.receiver_uid
    WHEN friend_requests.receiver_uid ='$user_uid' THEN  friend_requests.sender_uid
 END)
 WHERE 
`friend_requests`.`status` ='Accepted'
GROUP BY friend_requests.id", false);



    

echo json_encode($friends, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
<?php
include "config.php";





$user_uid = $_GET['user_uid'];
$search_word = $_GET['search_word'];

 

   $friends = readRowFromSql(" SELECT 
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
    WHERE ( users.full_name  LIKE '%$search_word%'OR users.short_digital_id LIKE '%$search_word%' AND `friend_requests`.`status` ='Accepted')AND(
     users.uid!='$user_uid'
    )
GROUP BY  users.uid", false);


    

echo json_encode($friends, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
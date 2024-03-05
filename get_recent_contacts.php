<?php
include "config.php";





$user_uid = $_GET['user_uid'];
    
    $friends = readRowFromSql("SELECT 
 users.uid,
 users.gender,
 users.bio,
 users.full_name,
 users.profile_pic
 FROM posts 
 INNER JOIN posts_mentions ON posts_mentions.post=posts.id
INNER JOIN users ON posts_mentions.mention_to=users.uid
WHERE posts.publisher_uid = '$user_uid' 
GROUP BY users.id
", false);


 
    

echo json_encode($friends, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
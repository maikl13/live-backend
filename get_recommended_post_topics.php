<?php
include "config.php";
 
$user_uid = $_GET['user_uid'];
 
   
    $topics = readRowFromSql("SELECT topics_for_posts.* ,
     count(DISTINCT topics_followers.follower_uid)  AS followers,
     sum(DISTINCT gifts.value) AS gifts,
 count(DISTINCT posts2.id)  AS posts
    FROM posts 
    INNER JOIN topics_for_posts ON posts.topic=topics_for_posts.id
    LEFT OUTER JOIN topics_followers ON topics_followers.topic_id =topics_for_posts.id
LEFT OUTER JOIN posts posts2 ON posts2.topic =topics_for_posts.id
LEFT OUTER JOIN posts_gifts ON topics_followers.topic_id =topics_for_posts.id 
           LEFT OUTER JOIN gifts ON gifts.id =posts_gifts.gift_id 

WHERE posts.topic IS NOT NULL
GROUP BY topics_for_posts.id
ORDER BY posts.datetime
LIMIT 1
", false);

echo json_encode($topics, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>



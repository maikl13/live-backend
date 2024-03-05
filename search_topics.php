<?php
include "config.php";





$user_uid = $_GET['user_uid'];
$search_word = $_GET['search_word'];


   
    $topics = readRowFromSql("SELECT  topics_for_posts.* , count(DISTINCT topics_followers.follower_uid)  AS followers,
     sum(DISTINCT gifts.value) AS gifts,
 count(DISTINCT posts.id)  AS posts,
 EXISTS (SELECT * FROM `topics_followers` i_follow_it WHERE `i_follow_it`.`topic_id`=topics_for_posts.id AND `i_follow_it`.`follower_uid`='$user_uid') AS followed
FROM topics_for_posts
LEFT OUTER JOIN topics_followers ON topics_followers.topic_id =topics_for_posts.id
LEFT OUTER JOIN posts ON posts.topic =topics_for_posts.id
LEFT OUTER JOIN posts_gifts ON topics_followers.topic_id =topics_for_posts.id 
           LEFT OUTER JOIN gifts ON gifts.id =posts_gifts.gift_id 
WHERE topics_for_posts.title LIKE '%$search_word%'
GROUP BY topics_for_posts.id
", false);

echo json_encode($topics, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
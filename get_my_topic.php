<?php
include "config.php";

  $uid =$_GET['uid'];
 
  


$results = readRowFromSql(" 

SELECT topics_for_posts.* , count(DISTINCT topics_followers.follower_uid) AS followers,
 sum(DISTINCT gifts.value) AS gifts,
EXISTS (SELECT * FROM topics_followers me WHERE `me`.`topic_id`='$topic_id' AND `me`.`follower_uid`='$uid') AS followed ,
        count(DISTINCT posts.id) AS posts
        FROM topics_for_posts 
        LEFT OUTER JOIN topics_followers ON topics_followers.topic_id =topics_for_posts.id 
           LEFT OUTER JOIN posts_gifts ON topics_followers.topic_id =topics_for_posts.id 
           LEFT OUTER JOIN gifts ON gifts.id =posts_gifts.gift_id 
        LEFT OUTER JOIN posts ON posts.topic =topics_for_posts.id
        WHERE topics_for_posts.topic_host_uid = '$uid'
        
", true);
 


echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);



?>
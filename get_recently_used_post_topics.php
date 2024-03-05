<?php
include "config.php";
 
$user_uid = $_GET['user_uid'];
 
   
    $topics = readRowFromSql("SELECT topics_for_posts.* FROM posts 
INNER JOIN topics_for_posts ON posts.topic=topics_for_posts.id
WHERE posts.publisher_uid = '$user_uid' AND posts.topic IS NOT NULL
GROUP BY topics_for_posts.id
", false);

echo json_encode($topics, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>



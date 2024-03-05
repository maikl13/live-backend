<?php

$user_uid = $_GET['user_uid'];
$topic_id = $_GET['topic_id'];
$sorting = $_GET['sorting'];


include "format_posts_result.php";


 

  $results=get_posts_by_topic($user_uid,$topic_id,$sorting);
 

echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        


?>
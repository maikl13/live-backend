<?php
$user_uid = $_GET['user_uid'];
include "format_posts_result.php";





 
  $results=get_all_followed_people_posts($user_uid);
 

echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
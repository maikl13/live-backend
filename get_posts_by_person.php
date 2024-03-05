<?php

$user_uid = $_GET['user_uid'];
$followed_uid = $_GET['followed_uid'];
include "format_posts_result.php";





 
  $results=get_posts_by_person($user_uid,$followed_uid);
 

echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        


?>
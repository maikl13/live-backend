<?php
include "format_posts_result.php";



$user_uid = $_GET['user_uid'];
$room_id = $_GET['room_id'];

 
  $results= get_room_moments($user_uid,$room_id);
 

echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        


?>
<?php
include "config.php";


$post_id = $_GET['post_id'];
$user_uid = $_GET['user_uid'];

    $result = readRowFromSql("
SELECT 
`users`.`uid`, `users`.`full_name`
 ,`users`.`profile_pic` ,`users`.`bio` ,`users`.`gender` ,
  `users`,`current_premium_subscription`,
  `users`,`current_vip_subscription`
FROM `posts_likes` 

INNER JOIN `users` ON `users`.`uid`= `posts_likes`.`user_uid`
 

WHERE `posts_likes`.`post_id` =$post_id", false);

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        


?>



<?php
include "config.php";

$user_uid = $_GET['user_uid'];
 



$result= readRowFromSql("SELECT `moments_notifications`.* ,
 `posts_images`.`image` as notification_image,
 `users`.`full_name` as from_user_full_name,
 `users`.`profile_pic` as from_user_profile_pic,
 `comments`.`text` as text
FROM `moments_notifications`
INNER JOIN `users` ON `moments_notifications`.`from_user`=`users`.`uid`
INNER JOIN `posts` ON `moments_notifications`.`post_id`=`posts`.`id`
LEFT OUTER JOIN `posts_images` ON `moments_notifications`.`post_id`=`posts_images`.`post`
LEFT OUTER JOIN `comments` ON `moments_notifications`.`comment_id`=`comments`.`id`
WHERE `moments_notifications`.`to_user`='$user_uid' AND 
`moments_notifications`.`cleared`='0'
GROUP BY `moments_notifications`.`id`
ORDER BY `moments_notifications`.`datetime`

", false);


 


          

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
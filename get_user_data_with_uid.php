<?php
include "config.php";


$uid =$_GET['uid'];
$my_uid =$_GET['my_uid'];


$user = readRowFromSql("SELECT `users`.* ,
 COUNT(DISTINCT people_i_follow.id) as 'people_i_follow_count' ,
COUNT(DISTINCT people_follow_me.id) as 'people_follow_me_count' ,
COUNT(DISTINCT  user_rooms.id) as 'joined_rooms_count' ,
  
  COUNT(DISTINCT  users_visitors.id) as 'profile_visitors_count' ,
  
`countries`.`name` as country_name,  `countries`.`flag` as country_flag,
EXISTS (SELECT * FROM `followers`  WHERE `followers`.`follower_uid`='$my_uid'  AND `followers`.`followed_uid`='$uid') AS i_follow_them
,
EXISTS (SELECT  `friend_requests`.`id` FROM `friend_requests` WHERE  
((`friend_requests`.`sender_uid`='$uid' AND `friend_requests`.`receiver_uid` = '$my_uid')
OR
(`friend_requests`.`receiver_uid`='$uid' AND `friend_requests`.`sender_uid` = '$my_uid'))
AND
`friend_requests`.`status` ='Accepted') AS we_are_friends,
users.uid IN 
 (SELECT blocked_users.blocked FROM blocked_users WHERE  blocked_users.blocker='$my_uid') as blocked
FROM `users`
INNER JOIN countries ON countries.id=users.country 
 
LEFT OUTER JOIN `followers` people_i_follow ON people_i_follow.follower_uid='$uid'
LEFT OUTER JOIN `followers` people_follow_me ON people_follow_me.followed_uid ='$uid'
LEFT OUTER JOIN `users_visitors`  ON `users_visitors`.`visited_uid` ='$uid'
LEFT OUTER JOIN `user_rooms`  ON `user_rooms`.`user_uid` ='$uid' AND `user_rooms`.`is_joined`=1
 
 

WHERE users.uid = '$uid'
GROUP BY `users`.`id`
", true);


$tags = readRowFromSql("SELECT sub_tags.* FROM `users_tags`
INNER JOIN `sub_tags` ON `sub_tags`.`id` =`users_tags`.`tag_id`
WHERE `users_tags`.`user_uid` = '$uid' ", false);
$country['id']=$user['country'];
$country['name']=$user['country_name'];
$country['flag']=$user['country_flag'];
$user['country']=$country;
unset($user['country_name']);
unset($user['country_flag']);
$user['tags']=$tags;


echo json_encode($user, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
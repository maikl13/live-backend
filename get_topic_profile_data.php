<?php
include "config.php";

 // $user_uid =$_GET['user_uid'];
   $topic_id =$_GET['topic_id'];
  


$data = readRowFromSql("SELECT `topics_for_posts`.`rules` ,`topics_for_posts`.`language_code` 
, `users`.`uid` AS host_uid
    , `users`.`short_digital_id`  AS host_short_digital_id
    , `users`.`profile_pic`   AS host_profile_pic
    , `users`.`full_name`   AS host_full_name
    , `users`.`gender`   AS host_gender
FROM `topics_for_posts` 
INNER JOIN `users` ON `users`.`uid`=`topics_for_posts`.`topic_host_uid`
WHERE `topics_for_posts`.`id`=$topic_id", true);
 
 
  
$results['language_code']=$data['language_code'];
$results['rules']=$data['rules'];
$topic_host['uid']=$data['host_uid'];
$topic_host['short_digital_id']=$data['host_short_digital_id'];
$topic_host['profile_pic']=$data['host_profile_pic'];
$topic_host['full_name']=$data['host_full_name'];
$topic_host['gender']=$data['host_gender'];
$results['topic_host']=$topic_host;
$results['language_code']=$data['language_code'];
$results['language_code']=$data['language_code'];
$results['language_code']=$data['language_code'];

$new_followers = readRowFromSql("SELECT 
`users`.`uid`  
    , `users`.`short_digital_id`
    , `users`.`profile_pic`
    , `users`.`full_name` 
    , `users`.`gender` 
FROM `topics_followers` 
INNER JOIN `users` ON `users`.`uid`=`topics_followers`.`follower_uid`
WHERE `topics_followers`.`topic_id`=$topic_id
GROUP BY `topics_followers`.`id`
ORDER BY`topics_followers`.`datetime`  DESC", false);
$results['new_followers']=$new_followers;

$admins = readRowFromSql("SELECT 
`users`.`uid` 
    , `users`.`short_digital_id`
    , `users`.`profile_pic`
    , `users`.`full_name` 
    , `users`.`gender` 
FROM `topics_admins`
INNER JOIN `users` ON `users`.`uid`=`topics_admins`.`admin`
WHERE `topics_admins`.`topic`='$topic_id'
GROUP BY `topics_admins`.`id`
ORDER BY`topics_admins`.`datetime`  DESC", false);
$results['admins']=$admins;

$blocked_list = readRowFromSql("
  SELECT `topics_blocked_users`.`datetime`,
users.id,
users.uid,
users.full_name,
users.profile_pic,
users.level,
users.gender,
admin.full_name as admin_name
FROM `topics_blocked_users` 
INNER JOIN `users` users  ON users.`uid`=`topics_blocked_users`.`blocked_user`
INNER JOIN `users` admin  ON admin.`uid`=`topics_blocked_users`.`admin`
WHERE `topics_blocked_users`.`topic` ='$topic_id'  
GROUP BY  users.uid
ORDER BY`topics_blocked_users`.`datetime`  DESC", false);
$results['blocked_list']=$blocked_list;
echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);



?>
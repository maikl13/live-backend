
<?php
include "config.php";


$uid = $_GET['uid'];
$login_method = $_GET['login_method'];
$fcm_token = $_GET['fcm_token'];

$fullname = $_GET['fullname'];
$gender = $_GET['gender'];
$date_of_birth = $_GET['date_of_birth'];

$profile_pic = $_GET['profile_pic'];
$bio = $_GET['bio'];
$country = $_GET['country'];
$phone = $_GET['phone'];



 
 $short_digital_id=getUniqueID();
 
 
      $sqlINSERT = "INSERT INTO `users` 
      
      (`id`, `uid`, `short_digital_id`, `full_name`, `profile_pic`, `profile_cover`, `level`, `login_method`, `crystals`, `gold`, `fcm_token`, `selected_theme`, `gender`, `bio`, `date_of_birth`, `country`, `language_code`, `vehicle`, `chat_box`, `used_frame`, `current_premium_subscription`,`phone`) VALUES 
      
      
      (NULL, '$uid', '$short_digital_id', '$fullname', '$profile_pic', 'default_cover.jpg', '0', '$login_method', '0', '0', '$fcm_token', '0', '$gender', '$bio', '$date_of_birth', '$country', 'EN', NULL, '0', '1', NULL,'$phone');";
       $PostResult=updateSql($sqlINSERT);
       
       updateSql("  INSERT INTO `users_main_level` (`id`, `user`, `total_exp`, `date`) VALUES (NULL, '$uid', '0', NOW());");
     
          updateSql(" INSERT INTO `level_tasks_progress` (`id`, `user`, `task`, `exp`) VALUES (NULL, '$uid', '0', '0'), (NULL, '$uid', '1', '0'), (NULL, '$uid', '2', '0'), (NULL, '$uid', '3', '0');");
     
     
    
       //////////
        $users_daily_exp_to_spend_in_rooms= readRowFromSql("
  SELECT `constants`.`value` FROM `constants` WHERE
  `constants`.`constant_key`='users_daily_exp_to_spend_in_rooms'",true
    )['value'];
 updateSql("INSERT INTO `users_todayExpToSpendInRooms` (`user`, `todayExpToSpendInRooms`) VALUES ('$uid', '$users_daily_exp_to_spend_in_rooms')`");
 
 $user=getUserData($uid);
 $finalResault['user']=$user;
  $finalResault['open_full_all_data_page']=0;
echo json_encode($finalResault, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);    
      


function getUserData($uid){
     $user = readRowFromSql("SELECT `users`.* ,
  `topics_for_posts`.`id` as topic,

  COUNT(DISTINCT people_i_follow.id) as 'people_i_follow_count' ,
COUNT(DISTINCT people_follow_me.id) as 'people_follow_me_count' ,
COUNT(DISTINCT  users_visitors.id) as 'profile_visitors_count' ,
COUNT(DISTINCT  user_rooms.id) as 'joined_rooms_count' ,
  
`countries`.`name` as country_name,  `countries`.`flag` as country_flag,
 
rooms.title as room_title,
rooms.description as room_announcement,
rooms.short_digital_id as room_short_digital_id,
rooms.image as room_image,
rooms.room_level as room_level,
rooms.id as room_id,
COUNT(DISTINCT  room_members_count.id) as room_members_count


FROM `users`
LEFT OUTER JOIN `topics_for_posts` 
        ON `topics_for_posts`.`topic_host_uid` = `users`.`uid`
        
INNER JOIN countries ON countries.id=users.country 
 
 
LEFT OUTER JOIN `followers` people_i_follow ON people_i_follow.follower_uid='$uid'
LEFT OUTER JOIN `followers` people_follow_me ON people_follow_me.followed_uid ='$uid'
LEFT OUTER JOIN `users_visitors`  ON `users_visitors`.`visited_uid` ='$uid'
LEFT OUTER JOIN `rooms`  ON `rooms`.`creator_uid` ='$uid' 
LEFT OUTER JOIN `user_rooms` room_members_count ON room_members_count.`room_id` =rooms.id AND room_members_count.`is_joined`=1
LEFT OUTER JOIN `user_rooms`  ON `user_rooms`.`user_uid` ='$uid' AND `user_rooms`.`is_joined`=1
 
WHERE users.uid = '$uid'", true);



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
if($user['room_short_digital_id']!=null){
    $room['title']=$user['room_title'];
$room['announcement']=$user['room_announcement'];
$room['short_digital_id']=$user['room_short_digital_id'];
$room['image']=$user['room_image'];
$room['members_count']=$user['room_members_count'];
$room['level']=$user['room_level'];
$room['id']=$user['room_id'];
$user['room']=$room;
}else{
    $user['room']=null;
}


 
 
return $user;
}
function getUniqueID(){
     $allExistIDS = readRowFromSql("SELECT `users`.`short_digital_id` FROM `users` WHERE  `users`.`short_digital_id` IS NOT  NULL AND   `users`.`short_digital_id` !=''", false);
        $some_max_value=1000000;
       $already_in_database = array();
       foreach ($allExistIDS as $existID) {
            $already_in_database[] = $existID['short_digital_id'];  
       }
  
         $new = rand(0,$some_max_value);
         
         while(in_array($new,$already_in_database)){
        $new = rand(0,$some_max_value);
    
            }
            return $new;
}
?>
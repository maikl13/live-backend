
<?php
include "config.php";
include "send_on_enter_notification.php";


$uid = $_GET['uid'];
$login_method = $_GET['login_method'];
$fullname = $_GET['fullname'];
$fcm_token = $_GET['fcm_token'];
$ip = $_GET['ip'];
$device = $_GET['device'];

$full_all_data_before_login= readRowFromSql("SELECT `constants`.`value`  FROM `constants` WHERE `constants`.`constant_key`='full_all_data_before_login'", true)['value']=='1';


$result= readRowFromSql("SELECT `users`.`id` FROM users WHERE uid= '$uid'", true);
$user_exist=$result!=null;
if($full_all_data_before_login&&!$user_exist){
 
    $finalResault['open_full_all_data_page']=1;
}else{
 
   $finalResault['open_full_all_data_page']=0;
    if($result==null){
     //لو لوجن بس لا لكن بم انه اصلا زرار واحد يبقا ننشءله حساب
  $short_digital_id=getUniqueID();
 
 
      $sqlINSERT = "INSERT INTO `users` (`id`, `uid`, `short_digital_id`, `full_name`, `profile_pic`, `profile_cover`, `level`,
       `login_method`, `crystals`, `gold`, `fcm_token`, `selected_theme`, `gender`, `bio`,
        `date_of_birth`, `country`, `language_code`, `vehicle`, `chat_box`, `used_frame`, 
        `current_premium_subscription`
        ,`current_vip_subscription`,`join_date` ,`auto_firend_requists_accept`,`view_my_related_rooms`
        ,`account_status`,`agency_id` ,`agency_join_date`,`phone`
        ,`is_online`,`last_active` ,`ip`,`device`
        ) 
        
        
        VALUES (NULL, '$uid', '$short_digital_id', '$fullname', 
        'default_profile.jpg', 'default_cover.jpg', '0', '$login_method', '0', '0', '$fcm_token',
         '0', 'NOTSPECIFIED', 'Bio is left empty', CURRENT_TIMESTAMP, '1', 'EN', NULL, '0', '1',
          NULL
          ,NULL,CURDATE() ,0,0
        ,NULL,NULL ,NULL,NULL
        ,1,CURRENT_TIMESTAMP ,'$ip','$device');";
       $PostResult=updateSql($sqlINSERT);
       
       updateSql("  INSERT INTO `users_main_level` (`id`, `user`, `total_exp`, `date`) VALUES (NULL, '$uid', '0', NOW());");
     
          updateSql(" INSERT INTO `level_tasks_progress` (`id`, `user`, `task`, `exp`) VALUES (NULL, '$uid', '0', '0'), (NULL, '$uid', '1', '0'), (NULL, '$uid', '2', '0'), (NULL, '$uid', '3', '0');");
     
     
    
       //////////
        $users_daily_exp_to_spend_in_rooms= readRowFromSql("
  SELECT `constants`.`value` FROM `constants` WHERE
  `constants`.`constant_key`='users_daily_exp_to_spend_in_rooms'",true
    )['value'];
 updateSql("INSERT INTO `users_todayExpToSpendInRooms` (`user`, `todayExpToSpendInRooms`) VALUES ('$uid', '$users_daily_exp_to_spend_in_rooms')`");
  //////////


 
 
     
     
 }  

 $user=getUserData($uid);
 if($user_exist){
    $fullname=$user['full_name'];
    $fcmNotificatio=$user['fcm_token'];
    sendNotifications($fullname,$fcmNotificatio);
}
 $finalResault['user']=$user;

}

echo json_encode($finalResault, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);    
      


function getUserData($uid){
  
     $user = readRowFromSql("SELECT `users`.* ,
     `frames`.`icon` as frame_icon,
     `frames`.`padding` as frame_padding,
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
LEFT OUTER JOIN `frames` ON `frames`.`id`=`users`.`used_frame` 
 


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
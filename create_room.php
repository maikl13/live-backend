<?php
include "config.php";
include "pay.php";


$creator_uid = $_GET['creator_uid'];
$title = $_GET['title'];
$image= $_GET['image'];
$announcement= $_GET['announcement'];


$user = readRowFromSql("SELECT  users.country ,users.uid   
FROM `users`
WHERE users.uid = '$creator_uid'", true);


$country=$user['country'];
$short_digital_id=getUniqueID();
//agora verables
$channel_token=$user['uid'];
$channel_id=$user['uid'];
$rtm_channel_id=$user['uid'];
//
 
  $result = updateSql("
 INSERT INTO `rooms` 
 (`id`, `short_digital_id`, `country`, `channel_id`,
 `creator_uid`, `title`, `description`, `image`,
 `channel_token`, `theme`, `theme_type`, `create_datetime`,
 `hashtag`, `number_of_mics`, `rtm_channel_id`,
 
 `locked_mics_indexes`, `membership_fee`, `room_level`, `allow_admins_to_lock_or_unlock_the_mic`, `allow_admins_to_turn_on_or_off_the_mic_application`, `allow_admins_to_manage_events`, `allow_guests_to_enter`, `enter_lock`, `mic_application_is_turned_on`, `mic_for_members_only`, `room_grade`, `total_exp`) VALUES 
 (NULL, '$short_digital_id', '$country', '$channel_id', '$creator_uid', '$title', '$announcement', '$image', '$channel_token', '8', 'STORE', CURRENT_TIMESTAMP, '2', '10', '$rtm_channel_id', '[]', '20', '0',
 '0', '0', '0', '0', NULL, '0', '0', '1', '0')");
 
 


function getUniqueID(){
     $allExistIDS = readRowFromSql("SELECT `rooms`.`short_digital_id` FROM `rooms`", false);
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
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
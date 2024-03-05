<?php
include "config.php";

$uid =$_GET['uid'];
$room_id =$_GET['room_id'];
$number_of_mics =$_GET['number_of_mics'];




$occupiers = readRowFromSql("SELECT 
`vehicles`.`id` as vehicle_id,
  `vehicles`.`animated_image` as vehicle_animated_image,
  `vehicles`.`image` as vehicle_image,

room_occupier_on_enter.*,
users.full_name as user_full_name,
users.profile_pic as user_profile_pic,
users.level as user_level,
users.short_digital_id as short_digital_id,
users.current_premium_subscription,
users.current_vip_subscription,
user_rooms.is_joined AS is_joined,


EXISTS (SELECT  `friend_requests`.`id` FROM `friend_requests` WHERE  
((`friend_requests`.`sender_uid`='$uid' AND `friend_requests`.`receiver_uid` = `users`.`uid`)
OR
(`friend_requests`.`receiver_uid`='$uid' AND `friend_requests`.`sender_uid` = `users`.`uid`))
AND
`friend_requests`.`status` ='Accepted') AS we_are_friends,
EXISTS (SELECT rooms_admins.id  FROM `rooms_admins` WHERE `rooms_admins`.`user`=`users`.`uid` AND `rooms_admins`.`room`='$room_id') AS is_admin,


 
 CASE WHEN users_unlocked_frames.id IS NOT NULL || frames.limited_days IS NULL
 THEN    frames.icon ELSE NULL END as frame_icon,

 CASE WHEN users_unlocked_frames.id IS NOT NULL || frames.limited_days IS NULL
 THEN    frames.padding ELSE NULL END as frame_padding 



FROM `room_occupier_on_enter` 
INNER JOIN `users` ON `users`.`uid`=`room_occupier_on_enter`.`user_uid`
LEFT OUTER JOIN `vehicles` on `vehicles`.`id`=`users`.`vehicle`
LEFT OUTER  JOIN `users_vehicles`ON `users_vehicles`.`vehicle` =`vehicles`.`id`
AND `users_vehicles`.`user`=`users`.`uid`
 AND CURDATE()< DATE_ADD(`users_vehicles`.`purchase_date`, INTERVAL 30 DAY) 


 INNER JOIN frames  ON users.used_frame = frames.id  
  LEFT OUTER JOIN users_unlocked_frames  ON
users_unlocked_frames.frame=frames.id AND users_unlocked_frames.user=users.uid AND
CURDATE() <= date_add(`users_unlocked_frames`.`datetime` ,interval frames.limited_days day)

 
 
INNER JOIN `user_rooms` on `users`.`uid`=`user_rooms`.`user_uid` AND user_rooms.room_id = $room_id





WHERE `room_occupier_on_enter`.room_id='$room_id'", false);



$formatedResult=Array();
foreach ($occupiers as $occupier) {
$formatedOccupier=[];    
$formatedOccupier["index"]=$occupier["index"];
$formatedOccupier["place_is_occupied"]=true;
$occupierUserData=[];    
$occupierUserData["full_name"]=$occupier["user_full_name"];
$occupierUserData["frame_icon"]=$occupier["frame_icon"];
$occupierUserData["frame_padding"]=$occupier["frame_padding"];


 
$occupierUserData["level"]=$occupier["user_level"];
$occupierUserData["profile_pic"]=$occupier["user_profile_pic"];
$occupierUserData["current_premium_subscription"]=$occupier["current_premium_subscription"];
 
$occupierUserData["current_vip_subscription"]=$occupier["current_vip_subscription"];
$occupierUserData["uid"]=$occupier["user_uid"];
$occupierUserData["we_are_friends"]=$occupier["we_are_friends"];
$occupierUserData["is_admin"]=$occupier["is_admin"];
$occupierUserData["short_digital_id"]=$occupier["short_digital_id"];
$occupierUserData["local_uid"]=$occupier["local_uid"];
$occupierUserData["is_joined"]=$occupier["is_joined"];


   if($occupier['vehicle_id']!=null){
      
    $vehicle_in_room['id']=$occupier['vehicle_id'];
$vehicle_in_room['image']=$occupier['vehicle_image'];
$vehicle_in_room['animated_image']=$occupier['vehicle_animated_image'];
  $occupierUserData['vehicle_in_room']=$vehicle_in_room;
   
}


$formatedOccupier["occupier"]=$occupierUserData;
$formatedResult[]=$formatedOccupier;
}

$AllPlacesList=Array();

for ($x = 1; $x <= $number_of_mics; $x++) {
    $this_index_is_occupied=false;
    foreach ($formatedResult as $formated_occupier) {
        $current_insed=$formated_occupier["index"];
        if($current_insed==$x){
            $this_index_is_occupied=true;
             $AllPlacesList[]=$formated_occupier;
        }
    }
    if($this_index_is_occupied){
       
    }else{
        $emptyOccupier=[];    
$emptyOccupier["index"]=$x;
$emptyOccupier["place_is_occupied"]=false;
  $AllPlacesList[]=$emptyOccupier;
    }
    
    


}
 $locked_mics= readRowFromSql("SELECT  `rooms`.`locked_mics_indexes` FROM `rooms` WHERE `rooms`.`id`='$room_id'", true);
 $locked_mics_indexes=json_decode($locked_mics['locked_mics_indexes']);



$filaList=array();
foreach($AllPlacesList as $place){
     $place_is_locked=false;
    foreach($locked_mics_indexes as $locked_mics_index){
       
        if($locked_mics_index==$place['index']){
            $place_is_locked=true;
        }
    }
    
    $place["place_is_locked"]=$place_is_locked;
    $filaList[]=$place;
}

echo json_encode($filaList, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
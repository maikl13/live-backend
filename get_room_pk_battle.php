<?php
include "config.php";

$room= $_GET['room_id'];

$battleData= readRowFromSql("SELECT 
`pk_battles`.`id`,
`pk_battles`.`ended_at`,
`pk_battles`.`started_at`,
`pk_battles`.`period_in_min`,
`pk_battles`.`admin_team_number`,
`pk_battles`.`remaining_seconds`,



pk_battle_teams1.total_gold AS team1balance,
pk_battle_teams2.total_gold AS team2balance
FROM 
`pk_battles` 
LEFT OUTER JOIN 
pk_battle_teams pk_battle_teams1 ON pk_battle_teams1.battle = `pk_battles`.`id` AND pk_battle_teams1.team_number = 1
LEFT OUTER JOIN 
pk_battle_teams pk_battle_teams2 ON pk_battle_teams2.battle = `pk_battles`.`id` AND pk_battle_teams2.team_number = 2
WHERE 
`pk_battles`.`room` = '$room'   
AND `pk_battles`.`ended_by_admin` = 0 
AND (`pk_battles`.`ended_at` > CURRENT_TIMESTAMP OR `pk_battles`.`ended_at` IS NULL)
GROUP BY 
`pk_battles`.`id`
LIMIT 1; 
", true);
 
$battle=$battleData['id'];
 
 if($battle!=NULL){
 
 
//new

$occupiers = readRowFromSql("SELECT 
`vehicles`.`id` as vehicle_id,
  `vehicles`.`animated_image` as vehicle_animated_image,
  `vehicles`.`image` as vehicle_image,
 
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
EXISTS (SELECT rooms_admins.id  FROM `rooms_admins` WHERE `rooms_admins`.`user`=`users`.`uid` AND `rooms_admins`.`room`='$room') AS is_admin,


 
 CASE WHEN users_unlocked_frames.id IS NOT NULL || frames.limited_days IS NULL
 THEN    frames.icon ELSE NULL END as frame_icon,

 CASE WHEN users_unlocked_frames.id IS NOT NULL || frames.limited_days IS NULL
 THEN    frames.padding ELSE NULL END as frame_padding ,
`pk_mic_places`.`locked`  ,
`pk_mic_places`.`place_index`,
`users`.`uid` as userUID
 
 
FROM `pk_mic_places` 
LEFT OUTER JOIN `users` ON `pk_mic_places`.`user`=`users`.`uid`
LEFT OUTER JOIN `vehicles` on `vehicles`.`id`=`users`.`vehicle`
LEFT OUTER  JOIN `users_vehicles`ON `users_vehicles`.`vehicle` =`vehicles`.`id`
AND `users_vehicles`.`user`=`users`.`uid`
 AND CURDATE()< DATE_ADD(`users_vehicles`.`purchase_date`, INTERVAL 30 DAY) 


 LEFT OUTER JOIN  frames  ON users.used_frame = frames.id  
  LEFT OUTER JOIN users_unlocked_frames  ON
users_unlocked_frames.frame=frames.id AND users_unlocked_frames.user=users.uid AND
CURDATE() <= date_add(`users_unlocked_frames`.`datetime` ,interval frames.limited_days day)

 
 
LEFT OUTER JOIN `user_rooms` on `users`.`uid`=`user_rooms`.`user_uid` AND user_rooms.room_id = $room




WHERE `pk_mic_places`.`room`='$room' AND  `pk_mic_places`.`battle`='$battle' ", false);



$formatedResult=Array();
foreach ($occupiers as $occupier) {
$formatedOccupier=[];    
$formatedOccupier["index"]=$occupier["place_index"];
$formatedOccupier["place_is_occupied"]=$occupier["userUID"]==NULL?false:true;
$formatedOccupier["place_is_locked"]=$occupier["locked"]=='0'?false:true;
$occupierUserData=[];    
$occupierUserData["full_name"]=$occupier["user_full_name"];
$occupierUserData["frame_icon"]=$occupier["frame_icon"];
$occupierUserData["frame_padding"]=$occupier["frame_padding"];


 
$occupierUserData["level"]=$occupier["user_level"];
$occupierUserData["profile_pic"]=$occupier["user_profile_pic"];
$occupierUserData["current_premium_subscription"]=$occupier["current_premium_subscription"];
 
$occupierUserData["current_vip_subscription"]=$occupier["current_vip_subscription"];
$occupierUserData["uid"]=$occupier["userUID"];
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

if($formatedOccupier["place_is_occupied"]){
	$formatedOccupier["occupier"]=$occupierUserData;
}

$formatedResult[]=$formatedOccupier;
}

 
    
    
//end
 
$battleData['pk_places']=$formatedResult;
echo json_encode($battleData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

 }else{
	 echo NULL;
 }

?>
<?php
include "config.php";



$user_uid =$_GET['user_uid'];
 $room_id =$_GET['room_id'];
 


$lastDay = readRowFromSql("SELECT
SUM(gifts.value)*users_gifts.count  as contribution FROM    user_rooms
INNER JOIN users_gifts ON users_gifts.room_id= user_rooms.room_id and users_gifts.sender_uid='$user_uid'
INNER JOIN gifts ON gifts.id= users_gifts.gift_id  AND gifts.currency_type='GOLD'
WHERE user_rooms.room_id='$room_id' 
AND CURDATE() =  DATE_FORMAT(users_gifts.send_datetime, '%Y-%m-%d') 
  AND user_rooms.user_uid='$user_uid'          
 ", true)['contribution'];
 
$lastWeek = readRowFromSql("SELECT
SUM(gifts.value)*users_gifts.count  as contribution FROM    user_rooms
INNER JOIN users_gifts ON users_gifts.room_id= user_rooms.room_id and users_gifts.sender_uid='$user_uid'
INNER JOIN gifts ON gifts.id= users_gifts.gift_id  AND gifts.currency_type='GOLD'
WHERE user_rooms.room_id='$room_id' 
AND CURDATE() <= date_add(DATE_FORMAT(users_gifts.send_datetime, '%Y-%m-%d') ,interval 7 day)
  AND user_rooms.user_uid='$user_uid'          
 ", true)['contribution'];
 
 
 
 if($lastDay==null){
     $lastDay=0;
 } 
  
 if($lastWeek==null){
     $lastWeek=0;
 } 
$result['last_day']=$lastDay;
$result['last_week']=$lastWeek;
 
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
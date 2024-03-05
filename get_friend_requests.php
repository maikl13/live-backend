<?php
include "config.php";




$user_uid = $_GET['user_uid'];
$result=array();
    $list=readRowFromSql("SELECT friend_requests.id, friend_requests.status,friend_requests.message,
users.uid,
users.short_digital_id,
users.level,
users.full_name,
users.profile_pic
 
FROM friend_requests
INNER JOIN users ON users.uid = friend_requests.sender_uid
WHERE friend_requests.receiver_uid = '$user_uid'
", false);


 
 
foreach($list as $item){
    $formated['id']=$item['id'];
    $formated['status']=$item['status'];
    $formated['message']=$item['message'];
    $sender['uid']=$item['uid'];
    $sender['short_digital_id']=$item['short_digital_id'];
    $sender['level']=$item['level'];
    $sender['profile_pic']=$item['profile_pic'];
    $sender['full_name']=$item['full_name'];
    $formated['sender']=$sender;
    $result[]=$formated;
}

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

 

?>
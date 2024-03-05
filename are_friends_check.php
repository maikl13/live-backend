<?php
include "config.php";


$uid =$_GET['uid'];
$my_uid =$_GET['my_uid'];


$user = readRowFromSql("SELECT  
EXISTS (SELECT  `friend_requests`.`id` FROM `friend_requests` WHERE  
((`friend_requests`.`sender_uid`='$uid' AND `friend_requests`.`receiver_uid` = '$my_uid')
OR
(`friend_requests`.`receiver_uid`='$uid' AND `friend_requests`.`sender_uid` = '$my_uid'))
AND
`friend_requests`.`status` ='Accepted') AS we_are_friends
 
", true);

 


echo json_encode($user['we_are_friends'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
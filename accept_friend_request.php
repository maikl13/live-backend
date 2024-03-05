<?php
include "config.php";

 
$id =$_GET['id'];
$myUid =$_GET['user_uid'];

$details = readRowFromSql("SELECT friend_requests.sender_uid,friend_requests.receiver_uid FROM `friend_requests` WHERE 
friend_requests.id='$id'
", true);

$sender_uid=$details['sender_uid'];
$receiver_uid=$details['receiver_uid'];
if(alreadyFriends($sender_uid,$receiver_uid)){
    $result=false;
}else{
     $result = updateSql("UPDATE friend_requests SET friend_requests.status ='Accepted' WHERE friend_requests.id='$id'");
     //send message
 
  $old_con_id=   readRowFromSql("select c.id
from private_conversations c
where exists (select 1
                  from private_conversations_users cu
                  where cu.private_conversation_id = c.id and
                        cu.user_uid = '$myUid'
                 ) and
     exists (select 1
                  from private_conversations_users cu
                  where cu.private_conversation_id = c.id and
                        cu.user_uid = '$sender_uid'
                 )  
  "
, true)['id'];
$conID;
if($old_con_id==null){
    $newConID=InsertAndGetId("INSERT INTO `private_conversations` (`id`, `datetime`) VALUES (NULL, CURRENT_TIMESTAMP);");
    $conID=$newConID;
}else{
    $conID=$old_con_id;
}
  $hi_message = updateSql("INSERT INTO `private_messages` 
  (`id`, `content`, `private_conversation_id`, `sender_uid`, `content_type`, `datetime`, `seen`, `voice_duration`)
  VALUES 
  (NULL, 'We are friends now. Lets chat!', '$conID', '$myUid', 'text', CURRENT_TIMESTAMP, '0', NULL)");
 $u1 = updateSql("INSERT INTO `private_conversations_users` (`id`, `private_conversation_id`, `user_uid`) VALUES (NULL, '$conID', '$sender_uid');");
 $u2 = updateSql("INSERT INTO `private_conversations_users` (`id`, `private_conversation_id`, `user_uid`) VALUES (NULL, '$conID', '$receiver_uid');");

}
  
        
 
 
 
function alreadyFriends($request_sender_uid,$request_receiver_uid){
   
$get_are_friends = readRowFromSql("SELECT  `friend_requests`.`id` FROM `friend_requests` WHERE  
((`friend_requests`.`sender_uid`='$request_sender_uid' AND `friend_requests`.`receiver_uid` = '$request_receiver_uid')
OR
(`friend_requests`.`receiver_uid`='$request_sender_uid' AND `friend_requests`.`sender_uid` = '$request_receiver_uid'))
AND
`friend_requests`.`status` ='Accepted'
"
, true);

  $res= json_encode($get_are_friends);
   $bool =$res==='null'?false:true;
   
 
  return $bool;
}

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>


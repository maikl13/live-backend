<?php
include "config.php";

$request_sender_uid = $_GET['request_sender_uid'];
$request_receiver_uid = $_GET['request_receiver_uid'];
$message_to_be_sent = $_GET['message'];

   
 $is_blocked = readRowFromSql("SELECT `blocked_users`.`id`
 FROM `blocked_users` 
 WHERE 
( `blocked_users`.`blocker`='$request_sender_uid'
 AND `blocked_users`.`blocked`='$request_receiver_uid' )
 OR 
 (
  `blocked_users`.`blocker`='$request_receiver_uid'
 AND `blocked_users`.`blocked`='$request_sender_uid' 
 )
 
 ", true)['id'];
 if($is_blocked==null){
     $senderFriendsCount=getFriendsCount($request_sender_uid);
$receiverFriendsCount=getFriendsCount($request_receiver_uid);

$senderFriendsCeillingCount=getFriendsCeillingCount($request_sender_uid); 
$receiverFriendsCeillingCount=getFriendsCeillingCount($request_receiver_uid);

$areAlreadyFriends=alreadyFriends($request_sender_uid,$request_receiver_uid);

 
$succeeded="false";
$message="";
 
 
 
if(!$areAlreadyFriends){
  
    if($senderFriendsCount==$senderFriendsCeillingCount){
      
         $message="senderReachedFriendsCeiling";
    $succeeded="false";
    }else{
         if($receiverFriendsCount==$receiverFriendsCeillingCount){
        $message= "receiverReachedFriendsCeiling";
           $succeeded="false";
           
    }else{
           
        $resultSentBefore=iSentRequestBefore($request_sender_uid,$request_receiver_uid);
     
         
            $res= json_encode($resultSentBefore);
   if($res!='null'){
       $myID=$resultSentBefore['id'];
       $succeeded=updateOldRequest($myID,$message_to_be_sent);
   }else{
        $succeeded=sendFriendRequest($request_sender_uid,$request_receiver_uid,$message_to_be_sent);
       
   }
      
    }
    }
         
 
   
}else{
    if($areAlreadyFriends){
         $message= "areAlreadyFriends";
           $succeeded="false";
    }
   
}

$result['succeeded']=$succeeded;
$result['message']=$message;
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);




     
 }else{
   $result['succeeded']=false;
$result['message']="Can not send friend request because you have blocked each other";
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

  
 }
 







////////////////check if already friend request sent before (either of them had sent it)////////////////
function iSentRequestBefore($request_sender_uid,$request_receiver_uid){
$get_request_sent_before = readRowFromSql("
SELECT  `friend_requests`.`id` FROM `friend_requests` WHERE  
(`friend_requests`.`sender_uid`='$request_sender_uid' AND `friend_requests`.`receiver_uid` = '$request_receiver_uid')
AND
`friend_requests`.`status` ='Pending'
", true);


  
  return $get_request_sent_before;
}
////////////////////////////////////////////////Update Old Request////////////////////////////////////////////////
function updateOldRequest($id,$message_to_be_sent){
$updateOldRequest = updateSql("UPDATE friend_requests SET friend_requests.datetime =CURRENT_TIMESTAMP, 
friend_requests.message= '$message_to_be_sent' WHERE friend_requests.id='$id'
");


 $bool= json_encode($updateOldRequest);
 return $bool;
}

////////////////check if already friends////////////////
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

//get friends ceilling
function getFriendsCeillingCount($user_uid){
    //get premium data
  $get_user_premium_subscriptions=readRowFromSql("SELECT `users`.`current_premium_subscription` FROM `users` WHERE 
`users`.`uid`='$user_uid'", true);
  $user_is_premuim=$get_user_premium_subscriptions!=null;
   if($user_is_premuim){
       $user_premium_subscription=$get_user_premium_subscriptions['current_premium_subscription'];
       //todo getCountAccordingToPremium
       $getCountAccordingToPremium = readRowFromSql("SELECT `premium_subscription`.`max_friends_num`  FROM `premium_subscription` WHERE `premium_subscription`.`id`= '$user_premium_subscription'
", true);
$countAccordingToPremium=$getCountAccordingToPremium['max_friends_num'];
return $countAccordingToPremium;
   }else{
       return 1000; 
   } 
   
}

//get friends count
function getFriendsCount($user_uid){
$get_request_sender_friends_count = readRowFromSql("SELECT  COUNT(`friend_requests`.`id`) 
as request_sender_friends_count FROM `friend_requests` WHERE ( `friend_requests`.`sender_uid`='$user_uid' OR  `friend_requests`.`receiver_uid`='$user_uid')
AND (friend_requests.status ='Accepted'OR  friend_requests.status ='Pending') ", true);
$request_sender_friends_count=$get_request_sender_friends_count['request_sender_friends_count'];

 
   return $request_sender_friends_count;
}

function sendFriendRequest($request_sender_uid,$request_receiver_uid,$message_to_be_sent){
    $status="Pending";
    $auto_firend_requists_accept=readRowFromSql("SELECT  `users`.`auto_firend_requists_accept` FROM `users` WHERE `users`.`uid`='$request_receiver_uid'", true)['auto_firend_requists_accept'];
    if($auto_firend_requists_accept){
        $status="Accepted";
    }
    $sendFriendRequest = updateSql("
    INSERT INTO `friend_requests` (`id`, `sender_uid`, `receiver_uid`, `datetime`, `message`,`status`)
    VALUES (NULL, '$request_sender_uid', '$request_receiver_uid', CURRENT_TIMESTAMP, '$message_to_be_sent','$status');");
  $bool= json_encode($sendFriendRequest);
     return $bool;
}


?>
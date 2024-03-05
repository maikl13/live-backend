<?php
include "config.php";

/*
$room_id =$_GET['room_id'];



$allUnformatedMessages = readRowFromSql("SELECT
`message`.`message_id`,
`message`.`body`,
`message`.`sent_datetime`,
`message`.`type`,
`message`.`sender_uid`,
`message`.`is_reply`,
`message`.`has_mention`,
`message`.`mention_to`,


`reply`.`message_id`as message_we_are_replying_to_id, 
`reply`.`body`as message_we_are_replying_to_body,
`reply`.`type`as message_we_are_replying_to_type,
`reply`.`sender_uid`as message_we_are_replying_to_sender_uid,
`reply`.`has_mention`as message_we_are_replying_to_has_mention,
`reply`.`mention_to`as message_we_are_replying_to_mention_to,



`sender`.`full_name`,
`sender`.`level`,
`sender`  .`profile_pic`,
EXISTS (SELECT users_premium_subscriptions.subscription_id  FROM `users_premium_subscriptions` WHERE `users_premium_subscriptions`.`user_uid`=`message`.`sender_uid`) AS is_premium,
users_premium_subscriptions.subscription_id AS premium_subscription_id,

`user_we_are_replying_to`.`full_name` as  message_we_are_replying_to_full_name,
`user_we_are_replying_to`.`level`as  message_we_are_replying_to_level,
`user_we_are_replying_to` .`profile_pic`as  message_we_are_replying_to_profile_pic


FROM `messages` message  


LEFT OUTER JOIN users_premium_subscriptions ON `users_premium_subscriptions`.`user_uid`=`message`.`sender_uid`


INNER JOIN `users` sender ON   message.sender_uid =  sender.uid
LEFT OUTER JOIN `messages` reply ON   reply.message_id =  message.message_we_are_replying_to AND  message.is_reply = 1

LEFT OUTER JOIN `users` user_we_are_replying_to ON   reply.sender_uid =  user_we_are_replying_to.uid


WHERE message.room_id = $room_id ORDER BY `message`.`message_id`", false);


$formatedMessages=Array();
foreach ($allUnformatedMessages as $message) {
$formatedMessage=[];    
$formatedMessage["message_id"]=$message["message_id"];
$formatedMessage["sent_datetime"]=$message["sent_datetime"];
$formatedMessage["type"]=$message["type"];
$formatedMessage["has_mention"]=$message["has_mention"];
$formatedMessage["mention_to"]=$message["mention_to"];
$formatedMessage["is_reply"]=$message["is_reply"];


$sender["uid"]=$message["sender_uid"];
$sender["full_name"]=$message["full_name"];
$sender["level"]=$message["level"];
$sender["profile_pic"]=$message["profile_pic"];
$sender["is_premium"]=$message["is_premium"];
$sender["premium_subscription_id"]=$message["premium_subscription_id"];

$formatedMessage["sender"]=$sender;



  if($message["type"]=="GIFT"){
      $gift_id=$message["body"]; 
      $gift_body= readRowFromSql("SELECT `gifts`.`image` as gift_image,`users_gifts`.`count` as gift_count ,`users`.`full_name`  as gift_receiver FROM `users_gifts`
INNER JOIN  `gifts` ON   `gifts`.`id`=`users_gifts`.`gift_id`
INNER JOIN  `users` ON   `users`.`uid`=`users_gifts`.`receiver_uid`
WHERE `users_gifts`.`id`='$gift_id'", true);
    $formatedMessage["body"]=$gift_body;
}else{
   $formatedMessage["body"]=$message["body"]; 
}



if($message["is_reply"]){
    $message_we_are_replying_to=Array();
    $message_we_are_replying_to["message_id"]=$message["message_we_are_replying_to_id"];

$message_we_are_replying_to["type"]=$message["message_we_are_replying_to_type"];

$message_we_are_replying_to["has_mention"]=$message["message_we_are_replying_to_has_mention"];
$message_we_are_replying_to["mention_to"]=$message["message_we_are_replying_to_mention_to"];



$replying_to_sender["uid"]=$message["message_we_are_replying_to_sender_uid"];
$replying_to_sender["full_name"]=$message["message_we_are_replying_to_full_name"];
$message_we_are_replying_to["sender"]=$replying_to_sender;








  if($message["message_we_are_replying_to_type"]=="GIFT"){
      $reply_gift_id=$message["message_we_are_replying_to_body"]; 
      $reply_gift_body= readRowFromSql("SELECT `gifts`.`image` as gift_image,`users_gifts`.`count` as gift_count ,`users`.`full_name`  as gift_receiver FROM `users_gifts`
INNER JOIN  `gifts` ON   `gifts`.`id`=`users_gifts`.`gift_id`
INNER JOIN  `users` ON   `users`.`uid`=`users_gifts`.`receiver_uid`
WHERE `users_gifts` .id='$reply_gift_id'", true);
    $message_we_are_replying_to["body"]=$reply_gift_body;
}else{
 $message_we_are_replying_to["body"]=$message["message_we_are_replying_to_body"];
}
$formatedMessage["message_we_are_replying_to"]=$message_we_are_replying_to;


}


$formatedMessages[]=$formatedMessage;
    
}


echo json_encode($formatedMessages, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
*/
?>
<?php
include "config.php";

 
$user_uid = $_GET['user_uid'];
$private_conversation_id = $_GET['conversation_id'];

 
    $private_conversation = readRowFromSql("
    SELECT private_messages.id as messageId,private_messages.content,private_messages.voice_duration,
    private_messages.sender_uid as senderId,private_messages.content_type as type,
    private_messages.datetime as timestamp,private_messages.seen,
    private_gifts.gift_id as giftID,private_gifts.count as giftCount,gifts.image as giftImage
    FROM private_messages
    LEFT OUTER JOIN private_gifts ON private_gifts.message_id = private_messages.id
        LEFT OUTER JOIN gifts ON private_gifts.gift_id = gifts.id
    WHERE
private_messages.private_conversation_id='$private_conversation_id' 
ORDER BY private_messages.datetime
", false);
 
 $result=array();
 foreach($private_conversation as $message){
        $formated['messageId']=$message['messageId'];
        $formated['senderId']=$message['senderId'];
        $formated['type']=$message['type'];
        $formated['timestamp']=$message['timestamp'];
                  
     switch($message['type']){
         case 'text':
               $formated['text']=$message['content'];
             break;
        case 'gift':
               $formated['giftID']=$message['giftID'];
               $formated['giftCount']=$message['giftCount'];
               $formated['giftImage']=$message['giftImage'];
             break; 
      case 'voice':
               $formated['audioUrl']=$message['content'];
               $formated['duration']=$message['voice_duration'];
              
             break; 
     }
     $result[]=$formated;
   
 }

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        


?>



<?php
include "config.php";

 
$user_uid = $_GET['user_uid'];
 
    $private_conversations = readRowFromSql("SELECT
    pm1.content AS last_message_content,
    pm1.content_type AS last_message_content_type,
    pm1.datetime AS last_message_datetime,
    pc.id AS private_conversation_id,
    u2.full_name AS chat_user_full_name,
    u2.profile_pic AS chat_user_profile_pic,
    u2.uid AS chat_user_uid,
 
 CASE WHEN users_unlocked_frames.id IS NOT NULL || frames.limited_days IS NULL
 THEN    frames.icon ELSE NULL END as chat_user_frame_icon 
 
FROM
    private_conversations AS pc
    INNER JOIN private_messages AS pm1 ON pc.id = pm1.private_conversation_id
    INNER JOIN (
        SELECT
            private_conversation_id,
            MAX(datetime) AS max_datetime
        FROM
            private_messages
        GROUP BY
            private_conversation_id
    ) AS pm2 ON pc.id = pm2.private_conversation_id AND pm1.datetime = pm2.max_datetime
    INNER JOIN private_conversations_users AS pcu1 ON pc.id = pcu1.private_conversation_id
    INNER JOIN users AS u1 ON pcu1.user_uid = u1.uid
    INNER JOIN private_conversations_users AS pcu2 ON pc.id = pcu2.private_conversation_id
    INNER JOIN users AS u2 ON pcu2.user_uid = u2.uid
    
    INNER JOIN frames  ON u2.used_frame = frames.id  
  LEFT OUTER JOIN users_unlocked_frames  ON
users_unlocked_frames.frame=frames.id AND users_unlocked_frames.user=u2.uid AND
CURDATE() <= date_add(`users_unlocked_frames`.`datetime` ,interval frames.limited_days day)
    
WHERE
    u1.uid = '$user_uid'
    AND
    u2.uid != '$user_uid'
       GROUP BY
            private_conversation_id

", false);
$result=array();
foreach($private_conversations as $item){
      switch($item['last_message_content_type']){
        case 'gift':
               $item['last_message_content']=  '[Gift]';
       
             break; 
      case 'voice':
              $item['last_message_content']="[Voice]";
             break; 
     }
     $result[]=$item;
}
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        


?>



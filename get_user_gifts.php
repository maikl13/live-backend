<?php
include "config.php";




$uid =$_GET['uid'];


$result=readRowFromSql("select icon, gift_id,sum(number) total
from
(
   select   `users_gifts`.`count` AS number,
 
`gifts`.`icon` as icon,`gifts`.`id` as gift_id
FROM `users_gifts` 
INNER JOIN `gifts` ON   `users_gifts`.`gift_id`=gifts.id
WHERE `users_gifts`.`receiver_uid`='$uid'
 
    union all
  select  
 posts_gifts.count  AS number,
`gifts`.`icon` as icon,`gifts`.`id` as gift_id
FROM  posts_gifts
INNER JOIN `gifts` ON   posts_gifts.gift_id=`gifts`.`id`   
INNER JOIN posts ON posts.id= posts_gifts.post_id
WHERE posts.publisher_uid  ='$uid'
  union all
  select  
 private_gifts.count  AS number,
`gifts`.`icon` as icon,`gifts`.`id` as gift_id
FROM  private_gifts
INNER JOIN `gifts` ON   private_gifts.gift_id=`gifts`.`id`   
INNER JOIN private_messages ON private_messages.id= private_gifts.message_id
 INNER JOIN private_conversations ON private_conversations.id= private_messages.private_conversation_id
 INNER JOIN private_conversations_users   ON private_conversations_users.private_conversation_id= private_conversations.id  
AND  private_conversations_users.user_uid !='$uid'

) t
GROUP BY gift_id
 
", false);


 

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
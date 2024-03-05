<?php
include "config.php";

$uid =$_GET['uid'];
$result=array();


 $user=readRowFromSql("SELECT `users`.`current_premium_subscription`,`users`.`current_vip_subscription` FROM `users` WHERE 
`users`.`uid`='$uid'", true);
  $current_premium_subscription=$user['current_premium_subscription'];
 $current_vip_subscription=$user['current_vip_subscription'];

 
$is_premium=$current_premium_subscription!=null;
$is_vip=$current_vip_subscription!=null;


$vehicles= readRowFromSql(" 
SELECT 
    `chat_box`.*,
    `premium_subscription`.`title` as premium_type_title,
    

    
    
    EXISTS (SELECT * FROM `users_chat_boxes` 
                      WHERE `users_chat_boxes`.`user`='$uid' 
                        AND `users_chat_boxes`.`chat_box`=`chat_box`.`id` AND
                CURDATE() < DATE_ADD(`users_chat_boxes`.`purchase_date`, INTERVAL 7 DAY)
                      LIMIT 1) as owned,
    
    
    
    CASE
        WHEN `users`.`chat_box` = `users_chat_boxes`.`chat_box` AND `users`.`uid` = '$uid' THEN 1
        ELSE 0
    END as selected
FROM 
    `chat_box`
LEFT OUTER JOIN 
    `users_chat_boxes` ON `users_chat_boxes`.`chat_box` = `chat_box`.`id`
LEFT OUTER JOIN 
    `users` ON `users`.`uid` = users_chat_boxes.user
LEFT OUTER JOIN 
    `premium_subscription` ON `chat_box`.`premium_type` = `premium_subscription`.`id`
  
GROUP BY 
    `chat_box`.`id`;
"
, false);

 foreach($vehicles as $vehicle){
     if($vehicle['type']=='vip'&&$is_vip){
          $vehicle['owned']=1;
     }
      if($vehicle['type']=='premium'&&$is_premium){
          if($vehicle['premium_type']==$current_premium_subscription){
                  $vehicle['owned']=1;
          }
      
     }
     
  $result[]=$vehicle;
 }
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
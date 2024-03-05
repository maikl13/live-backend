<?php
include "config.php";


$post_id = $_GET['post_id'];
$user_uid = $_GET['user_uid'];
$result=array();
    $list = readRowFromSql("
select `gifts`.`image` as gift_image, `gifts`.`id`as gift_id, sum( posts_gifts.count ) total,
`users`.`uid`, `users`.`full_name`
 ,`users`.`profile_pic` ,`users`.`bio` ,`users`.`gender` ,`users`.`current_premium_subscription`,`users`.`current_vip_subscription`
 
FROM  `posts_gifts`
INNER JOIN `gifts` ON   `posts_gifts`.`gift_id`=`gifts`.`id`    
INNER JOIN `posts` ON `posts`.`id`= `posts_gifts`.`post_id`
INNER JOIN `users` ON   `posts_gifts`.`sender_uid`=`users`.`uid`
 
WHERE `posts_gifts`.`post_id`=  '$post_id'
 GROUP BY gift_id


", false);
foreach($list as $item){
    $formated['id']=$item['gift_id'];
    $formated['gift_image']=$item['gift_image'];
    $formated['total']=$item['total'];
    $sender['uid']=$item['uid'];
    $sender['short_digital_id']=$item['short_digital_id'];
    $sender['profile_pic']=$item['profile_pic'];
    $sender['full_name']=$item['full_name'];
    $sender['gender']=$item['gender'];
 
    $sender['current_premium_subscription']=$item['current_premium_subscription'];
        $sender['current_vip_subscription']=$item['current_vip_subscription'];
    $sender['bio']=$item['bio'];
    $formated['sender']=$sender;
    $result[]=$formated;
}

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        


?>



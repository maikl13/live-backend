<?php
include "config.php";


$adminShortId= $_GET['admin'];
$topic = $_GET['topic'];

$admin =readRowFromSql("SELECT `users`.`uid`
    , `users`.`short_digital_id`
    , `users`.`profile_pic`
    , `users`.`full_name` 
    , `users`.`gender` 
FROM `users` WHERE  `users`.`short_digital_id`='$adminShortId'", true);
$adminUID=$admin['uid'];
$adminsCount=readRowFromSql("SELECT COUNT(`topics_admins`.`id`)as count FROM `topics_admins` WHERE `topics_admins`.`topic`='$topic'
", true)['count'];


if($adminsCount<5){
    $follow=readRowFromSql("SELECT `topics_followers`.`id` FROM `topics_followers` WHERE  `topics_followers`.`topic_id`='$topic'
AND  `topics_followers`.`follower_uid`='$adminUID'", true)['id'];
    if($follow!=null){
        $alreadyExist=readRowFromSql("SELECT `topics_admins`.`id` FROM `topics_admins` WHERE
        `topics_admins`.`topic`='$topic' AND `topics_admins`.`admin`='$adminUID'", true)['id'];
        if($alreadyExist==null){
            $result = updateSql("INSERT INTO `topics_admins` (`id`, `topic`, `admin`, `datetime`) VALUES (NULL, '$topic', '$adminUID', CURRENT_TIMESTAMP);");
   if($result){
       echo json_encode($admin, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES); 
   }
        }
        
       
        
   

}else{
  echo '0';  
}
}else{
  echo '0';  
}



?>
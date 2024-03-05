<?php
include "config.php";

$room=$_GET['room'];
$user=$_GET['user'];
$admin=$_GET['admin'];
 

 $exist = readRowFromSql("SELECT `rooms_banned_from_chat_users`.`id` FROM `rooms_banned_from_chat_users` WHERE 
`rooms_banned_from_chat_users`.`room`= '$room'
AND 
`rooms_banned_from_chat_users`.`user`= '$user'", true) ;
if($exist==null){
     $current_vip_subscription = readRowFromSql("SELECT `users`.`current_vip_subscription` FROM `users` WHERE `users`.`uid`='$user'", true)['current_vip_subscription'];
   
 
    if(($current_vip_subscription==null)||($current_vip_subscription!=null&&$current_vip_subscription<5)){
        
       $result= updateSql("INSERT INTO `rooms_banned_from_chat_users`(`id`, `room`, `user`, `admin`, `datetime`) VALUES (NULL, '$room', '$user', '$admin' , CURRENT_TIMESTAMP);");
    }else{
      
        $result= false;  
    } 
   
}else{
  
  $result= false;
}
    


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
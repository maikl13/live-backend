<?php
include "config.php";

$room=$_GET['room'];
$user=$_GET['user'];
$admin=$_GET['admin'];
$permanently=$_GET['permanently'];

 $exist = readRowFromSql("SELECT `rooms_forbidden_users`.`id` FROM `rooms_forbidden_users` WHERE 
`rooms_forbidden_users`.`room`= '$room'
AND 
`rooms_forbidden_users`.`user`= '$user'", true);
if($exist==null){
     $current_vip_subscription = readRowFromSql("SELECT `users`.`current_vip_subscription` FROM `users` WHERE `users`.`uid`='$user'", true)['current_vip_subscription'];
 
    if(($current_vip_subscription==null)||($current_vip_subscription!=null&&$current_vip_subscription<5)){
       $result= updateSql("INSERT INTO `rooms_forbidden_users` (`id`, `room`, `user`, `admin`, `permanently`, `datetime`) VALUES (NULL, '$room', '$user', '$admin', '$permanently', CURRENT_TIMESTAMP);");
    }else{
        $result= false;  
    } 
   
}else{
  $result= false;
}
    if($result){
        $action=$permanently?"ban":"removeFromRoom";
       
    $record =  updateSql("INSERT INTO `action_records`
 (`id`, `admin`, `user`, `action`, `datetime`, `room`) VALUES 
 (NULL, '$admin', '$user', '$action', CURRENT_TIMESTAMP, '$room');" );
    }


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
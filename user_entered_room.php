<?php
include "config.php";


$user_uid =$_GET['user_uid'];
$room_id =$_GET['room_id'];

$user = readRowFromSql("SELECT * FROM `user_rooms` WHERE `user_rooms`.`user_uid`='$user_uid' AND room_id='$room_id'", true);


if($user==null){
    
     
        $result = updateSql("INSERT INTO `user_rooms` (`id`, `user_uid`, `room_id`, `is_joined`, `is_online`, `following`,`enter_datetime`) 
        VALUES (NULL, '$user_uid', '$room_id', '0', '1','0', CURRENT_TIMESTAMP);");
        
      
}else{
     $result = updateSql("UPDATE `user_rooms` SET `is_online` = '1',
     `enter_datetime` = CURRENT_TIMESTAMP WHERE `user_rooms`.`user_uid`='$user_uid' AND room_id='$room_id';");
     
     $result2 = updateSql("INSERT INTO `in_my_room_sessions` (`id`, `entered_at`, `left_at`, `finished`, `uid`,`room`) VALUES (NULL, current_timestamp(), NULL, '0', '$user_uid','$room_id');");
}





  echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
<?php
include "config.php";


function leaveRoomNow($user_uid,$room_id){
    
 $imExistAtSomeMic= readRowFromSql("SELECT  `room_occupier_on_enter`.`index` FROM `room_occupier_on_enter` WHERE `room_occupier_on_enter`.`user_uid`='$user_uid' AND `room_occupier_on_enter`.`room_id` = '$room_id'", true);
   if($imExistAtSomeMic){
             $myOldIndex=$imExistAtSomeMic['index'];
             $result = updateSql("DELETE FROM `room_occupier_on_enter` WHERE `room_occupier_on_enter`.`index` = '$myOldIndex' 
             AND `room_occupier_on_enter`.`room_id`='$room_id' ");
}    
$result = updateSql("UPDATE `user_rooms` SET `is_online` = '0'  WHERE `user_rooms`.`user_uid`='$user_uid' AND room_id='$room_id';");
$room_mic_application = updateSql("DELETE FROM `room_mic_application` WHERE `room_mic_application`.`user` = '$user_uid' AND `room_mic_application`.`room` = '$room_id'");
 
$result_pk_mic_places =  updateSql("UPDATE `pk_mic_places` SET `user` =NULL WHERE `user`='$user_uid'");  
  $result2 = updateSql("UPDATE `in_my_room_sessions` SET `left_at` =  current_timestamp(), `finished` = '1' WHERE `in_my_room_sessions`.`finished`=0 AND `in_my_room_sessions`.`uid`='$user_uid' AND `in_my_room_sessions`.`room`=$room_id");
     echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

}


?>
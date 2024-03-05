
<?php
include "config.php";

$room_id = $_GET['room_id'];
$user_uid = $_GET['user_uid'];
$role = $_GET['role'];

if($role=='1'){
    $isAlreadyAdmin = readRowFromSql("SELECT `rooms_admins`.`id` FROM `rooms_admins` WHERE `rooms_admins`.`user`= '$user_uid'AND `rooms_admins`.`room`= '$room_id'", true);

if($isAlreadyAdmin==null&&$isAlreadyAdmin==""){
    $room_data = readRowFromSql(" 
SELECT 
 room_upgrade_types.room_admin ,
 COUNT(DISTINCT rooms_admins.id) as adminsCount
 FROM `rooms`  
INNER JOIN room_upgrade_types ON room_upgrade_types.id= `rooms`.`room_grade`
LEFT OUTER JOIN  rooms_admins ON rooms_admins.room= `rooms`.`id`   
 
WHERE  `rooms`.`id`='$room_id'", true);
$room_admin_max=$room_data['room_admin'];
 
$adminsCount=$room_data['adminsCount'];
if($adminsCount<$room_admin_max){
     $result = updateSql("INSERT INTO `rooms_admins` (`id`, `user`, `room`) VALUES (NULL, '$user_uid', '$room_id');");   
      $resultReturn['message']="";
    $resultReturn['succeeded']=true;
}else{
    //todo message
 $resultReturn['message']="This room has the max number of admins";
    $resultReturn['succeeded']=false;
}
    
     
       
    
}
}else if($role=='0'){
  $result = updateSql("DELETE FROM `rooms_admins` WHERE `rooms_admins`.`user`='$user_uid' AND `rooms_admins`.`room`='$room_id'");    
    $resultReturn['message']="";
    $resultReturn['succeeded']=true;   

}






          
          
          
      


echo json_encode($resultReturn, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
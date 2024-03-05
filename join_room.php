<?php
include "config.php";
include "pay.php";


$user_uid =$_GET['user_uid'];
$room_id =$_GET['room_id'];
$iWantToJoin =$_GET['i_want_to_join'];
$unjoinAndUnfollow =$_GET['unjoin_and_unfollow'];
 $resultReturn=array();
  

$newJoingValue=$iWantToJoin?'1':'0';
  $newfollowValue=$unjoinAndUnfollow?'0':'1';
      $result = updateSql("UPDATE `user_rooms` SET `following` = $newfollowValue,`is_joined` = $newJoingValue WHERE `user_rooms`.`user_uid`='$user_uid' AND room_id='$room_id';");

 if($result){
         
if($iWantToJoin){
      
               
$room_data = readRowFromSql(" 
SELECT `rooms`.`membership_fee`,
 `rooms`.`members_count`,
`rooms`.`creator_uid`,room_upgrade_types.room_member FROM `rooms`  
INNER JOIN room_upgrade_types ON room_upgrade_types.id= `rooms`.`room_grade`
WHERE  `rooms`.`id`='$room_id'", true);
$room_member=$room_data['room_member'];
$members_count=$room_data['members_count'];


if($members_count<$room_member){
 
    $membership_fee=$room_data['membership_fee'];
$room_creator_uid=$room_data['creator_uid'];
$creator_uid=$room_data['creator_uid'];
    if($membership_fee!=null&&$membership_fee!=""&&$membership_fee!=0){
      
       $paied= payNow($user_uid,$membership_fee,'g');
          
       if($paied){
               
          addToWallet($room_creator_uid,$membership_fee,'g'); 
           setLevel($user_uid,$room_id);

       }else{
              $resultReturn['message']="not enogh golds";
    $resultReturn['succeeded']=false;
    
       }

    }else{
     setLevel($user_uid,$room_id);
    }
    
}else{
    $resultReturn['message']="the room is full";
    $resultReturn['succeeded']=false;
}

    
}else{
      $result = updateSql("   UPDATE `rooms` SET `members_count` = members_count-1 WHERE `rooms`.`id` = $room_id;");
    $resultReturn['message']="";
    $resultReturn['succeeded']=true;
}     
 }

function setLevel($user_uid,$room_id){
      
    global $resultReturn;
  $oldLevelID=readRowFromSql("SELECT  `userInRoomLevelTotal`.`id` FROM `userInRoomLevelTotal` WHERE 
`userInRoomLevelTotal`.`user`='$user_uid' AND `userInRoomLevelTotal`.`room` = '$room_id'")['id'];
    if($oldLevelID==null){
           
       $result = updateSql("INSERT INTO `userInRoomLevelTotal` 
      (`id`, `user`, `totalPoints`, `room`, `currentLevel`) VALUES 
      (NULL, '$user_uid', '0', '$room_id', '0');");
   
    } 
      $result = updateSql("   UPDATE `rooms` SET `members_count` = members_count+1 WHERE `rooms`.`id` = $room_id;");
 
    $resultReturn['message']="";
    $resultReturn['succeeded']=true;
 

}


  
  echo json_encode($resultReturn, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
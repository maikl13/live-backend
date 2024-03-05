<?php
include "config.php";




$room_id = $_GET['room_id'];
$index = $_GET['index'];
$user_uid = $_GET['user_uid'];
$localUid = $_GET['local_uid'];


$micForSpeceficMembersOnly= readRowFromSql("SELECT `mic_allowed`.`user_uid` FROM `mic_allowed` WHERE room_id=$room_id", true);
if($micForSpeceficMembersOnly!=null){
    $imAllowed= readRowFromSql("SELECT `mic_allowed`.`user_uid` FROM `mic_allowed` WHERE room_id=$room_id AND user_uid='$user_uid'", true);
    $imAllowedToOccupy=$imAllowed!=null;
}else{
    $imAllowedToOccupy=true;
}

if($imAllowedToOccupy){
    $indexIsFree= readRowFromSql("SELECT  `room_occupier_on_enter`.`user_uid` FROM `room_occupier_on_enter` WHERE `room_occupier_on_enter`.`index`='$index' AND `room_occupier_on_enter`.`room_id` = '$room_id'", true);

if($indexIsFree!=null){
    $currentUserAtThisIndex=$indexIsFree['user_uid'];
    $imExistAtThisIndex=$currentUserAtThisIndex==$user_uid?true:false;
    if($imExistAtThisIndex){
             $result = updateSql("DELETE FROM `room_occupier_on_enter` WHERE `room_occupier_on_enter`.`index` = '$index' 
             AND `room_occupier_on_enter`.`room_id`='$room_id' ");
    }else{
        //  show user card data
    }
}else{
    
      $imExistAtSomeMic= readRowFromSql("SELECT  `room_occupier_on_enter`.`index` FROM `room_occupier_on_enter` WHERE `room_occupier_on_enter`.`user_uid`='$user_uid' AND `room_occupier_on_enter`.`room_id` = '$room_id'", true);
       
         if($imExistAtSomeMic){
             //change my place   
             $myOldIndex=$imExistAtSomeMic['index'];
             $result = updateSql("DELETE FROM `room_occupier_on_enter` WHERE `room_occupier_on_enter`.`index` = '$myOldIndex' 
             AND `room_occupier_on_enter`.`room_id`='$room_id' ");
         }
             
      updateSql("DELETE FROM `room_occupier_on_enter` WHERE `room_occupier_on_enter`.`user_uid`='$user_uid'");  
 $code ="INSERT INTO `room_occupier_on_enter` 
 (`id`, `room_id`, `user_uid`, `index`, `local_uid`) VALUES
  (NULL, '$room_id', '$user_uid', '$index', $localUid);";
      $result = updateSql($code);  
 
   
}
$theResult['succeeded']=$result;
$theResult['message']="";


}else{
 $theResult['succeeded']=false;
$theResult['message']="NotAllowed";
} 

echo json_encode($theResult, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);





?>

<?php
include "config.php";


$user_uid = $_GET['user_uid'];
$room_id = $_GET['room_id'];
$index = $_GET['index'];
$lock = $_GET['lock'];


 $locked_mics= readRowFromSql("SELECT  `rooms`.`locked_mics_indexes` FROM `rooms` WHERE `rooms`.`id`='$room_id'", true);
 $list=json_decode($locked_mics['locked_mics_indexes']);

 $locked_mics_indexes=array();
 foreach($list as $item){
     if($lock){
       $locked_mics_indexes[]=$item;   
     }else{
         if($item!=$index){
             $locked_mics_indexes[]=$item;   
         }
     }
    
 }

 
 if($lock){
 $locked_mics_indexes[]=$index;
 }
$newList =  implode(",", $locked_mics_indexes);
$newnew="[$newList]";
 $result = updateSql("UPDATE `rooms` SET `locked_mics_indexes` = '$newnew'  WHERE `rooms`.`id`='$room_id'");
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>


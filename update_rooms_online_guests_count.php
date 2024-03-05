<?php
include "config.php";


 
$room  =$_GET['room'];
$isPlus =$_GET['is_plus'];

 $found = readRowFromSql("SELECT rooms_online_guests_count.id 
 FROM `rooms_online_guests_count` WHERE
 `rooms_online_guests_count`.`room`='$room'", true);


if($found!=null){
    $newCount='';
    if($isPlus){
        $newCount='online_guests_count+1';
    }else{
          $newCount='online_guests_count-1';
    }
    $result = updateSql("UPDATE `rooms_online_guests_count` SET `online_guests_count` =$newCount WHERE
 `rooms_online_guests_count`.`room`='$room'");

}else{
    $result = updateSql("INSERT INTO `rooms_online_guests_count` 
    (`id`, `room`, `online_guests_count`) VALUES 
    (NULL, '$room', '1');");

}
  
 
  echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
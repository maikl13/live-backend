<?php
include "config.php";

$user = $_GET['user'];
$interested = $_GET['interested'];
$event=$_GET['event'];
   //check
 $exist = readRowFromSql("SELECT `events_interested_users`.`id` FROM `events_interested_users` WHERE `events_interested_users`.`user_uid`='$user' AND `events_interested_users`.`event` ='$event'", true)['id'];
if($interested){
   
    if($exist==null){
           //add
             $result = updateSql("INSERT INTO `events_interested_users` (`id`, `user_uid`, `event`) VALUES (NULL, '$user', '$event');");
    }else{
        $result= 'Already interested';
    }
}else{
    if($exist!=null){
        //remove
          $result = updateSql("DELETE FROM `events_interested_users` WHERE `events_interested_users`.`id` = '$exist'");
    }else{
          $result= 'Already not interested';
    }
}


 

          

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";
include "events_manager.php";
 
$user=$_GET['user'];
$room =$_GET['room'];
 
 $event=getEvents($user,'eventsOfRoom','liveOrInLessThan30minSort',$room)[0];
 

 if($event==null){
      $result['found']=0;
 }else{
      $result['found']=1;
      $result['event']=$event;
 }
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

 


?>
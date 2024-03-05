<?php
include "config.php";
include "events_manager.php";
 
$user=$_GET['user'];
$sort =$_GET['sort'];
$section =$_GET['section'];
$room=$_GET['room'];
if($room==null||$room=='null'){
    $room="";
}
if($sort==null||$sort=='null'){
    $sort="";
}
 $list=getEvents($user,$section,$sort,$room);
 
echo json_encode($list, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

 


?>
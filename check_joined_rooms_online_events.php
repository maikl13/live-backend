<?php
include "config.php";
include "events_manager.php";
 
$user=$_GET['user'];
 
 $list=checkJoinedRoomsOnlineEvents($user);
 
echo json_encode($list, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

 


?>
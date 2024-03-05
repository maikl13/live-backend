<?php
include "config.php";
include "red_dots_manager.php";
 
$user=$_GET['user'];
 
 //$result['tasks']=thereIsUnseenDoneTasks( $user);
 $result=thereIsUnseenDoneTasks( $user);
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

 


?>
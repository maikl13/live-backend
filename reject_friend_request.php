<?php
include "config.php";

 
$id =$_GET['id'];


   $result = updateSql("UPDATE friend_requests SET friend_requests.status ='Rejected' WHERE friend_requests.id='$id'");
        
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";

$room=$_GET['room'];
$user=$_GET['user'];
$admin=$_GET['admin'];
 
 
    $result =  updateSql("INSERT INTO `action_records`
 (`id`, `admin`, `user`, `action`, `datetime`, `room`) VALUES 
 (NULL, '$admin', '$user', 'removeFromMic', CURRENT_TIMESTAMP, '$room');" );
 

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
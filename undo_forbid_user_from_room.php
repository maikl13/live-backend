<?php
include "config.php";

$room=$_GET['room'];
$user=$_GET['user'];
$admin=$_GET['admin'];


 $result =  updateSql("DELETE FROM `rooms_forbidden_users` WHERE `rooms_forbidden_users`.`room`= '$room'
AND 
`rooms_forbidden_users`.`user`= '$user'" );
 
 $result =  updateSql("INSERT INTO `action_records`
 (`id`, `admin`, `user`, `action`, `datetime`, `room`) VALUES 
 (NULL, '$admin', '$user', 'unban', CURRENT_TIMESTAMP, '$room');" );

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
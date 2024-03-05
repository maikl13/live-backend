<?php
include "config.php";
include "events_manager.php";
 
$user=$_GET['user'];
$event=$_GET['event'];
$result = readRowFromSql("SELECT`users`.`uid`, `users`.`full_name`
 ,`users`.`profile_pic` ,`users`.`bio` ,`users`.`gender` ,`users`.`current_premium_subscription`
 FROM `users`
INNER JOIN `events_interested_users` ON `users`.`uid`=`events_interested_users`.`user_uid`
WHERE  `events_interested_users`.`event`='$event' ",false);
 
 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);



?>

 

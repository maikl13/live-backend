<?php
include "config.php";
 
 
$user=$_GET['user'];
$event=$_GET['event'];
$creator = readRowFromSql("SELECT`users`.`uid`, `users`.`full_name`
 ,`users`.`profile_pic` ,`users`.`bio` ,`users`.`gender` ,`users`.`current_premium_subscription`
 FROM `users`
INNER JOIN `events` ON `users`.`uid`=`events`.`creator_uid`
WHERE  `events`.`id`='$event' ",true);
$result['creator']=$creator;
 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);



?>

 

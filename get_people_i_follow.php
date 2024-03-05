<?php
include "config.php";


$user_uid = $_GET['user_uid'];

 $result = readRowFromSql("SELECT`users`.`uid`, `users`.`full_name`
 ,`users`.`profile_pic` ,`users`.`bio` ,`users`.`gender` ,
 `users`.`current_premium_subscription`
 
 FROM `followers`

INNER JOIN `users` ON `users`.`uid`=`followers`.`followed_uid`
WHERE  `followers`.`follower_uid`='$user_uid' ORDER BY  `followers`.`datetime`", false);



echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
<?php
include "config.php";

$country = $_GET['country'];
$user_uid = $_GET['user_uid'];




   
   
   $result = updateSql("UPDATE `users` SET `country` = '$country' WHERE `users`.`uid` = '$user_uid';");
        
   $result = updateSql("UPDATE `rooms` SET `country` = '$country' WHERE `rooms`.`creator_uid` = '$user_uid';");
  


   
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
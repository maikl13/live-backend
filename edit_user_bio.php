<?php
include "config.php";

$bio = $_GET['bio'];
$user_uid = $_GET['user_uid'];




   
   
   $result = updateSql("UPDATE `users` SET `bio` = '$bio' WHERE `users`.`uid` = '$user_uid';");
        

  


   
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
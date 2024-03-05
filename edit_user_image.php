<?php
include "config.php";


$user_uid = $_GET['user_uid'];
$image = $_GET['image'];




   
   $result_add = updateSql("UPDATE `users` SET `profile_pic` = '$image' WHERE `users`.`uid` = '$user_uid';");
        

  


   
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
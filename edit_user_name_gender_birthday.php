<?php
include "config.php";


$user_uid = $_GET['user_uid'];
$full_name = $_GET['full_name'];
$gender = $_GET['gender'];
$date_of_birth = $_GET['date_of_birth'];



   
   $result_add = updateSql("UPDATE `users` SET `full_name` = '$full_name' , `gender` = '$gender' , `date_of_birth` = '$date_of_birth' WHERE `users`.`uid` = '$user_uid';");
        

  


   
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
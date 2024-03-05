<?php
include "config.php";

$user_uid = $_GET['user_uid'];
 



$firstTime= readRowFromSql("SELECT `users_moments_last_check_date`.`moments_last_check_date` FROM `users_moments_last_check_date` WHERE `users_moments_last_check_date`.`user`='$user_uid'", true)==null;


if($firstTime){
      $result = updateSql("INSERT INTO `users_moments_last_check_date` (`user`, `moments_last_check_date`) VALUES ('$user_uid',CURRENT_TIMESTAMP);");
}else{
       $result = updateSql("UPDATE `users_moments_last_check_date` SET `moments_last_check_date` =CURRENT_TIMESTAMP WHERE `users_moments_last_check_date`.`user` = '$user_uid';");
}


          

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
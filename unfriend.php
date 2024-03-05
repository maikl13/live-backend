 

<?php
include "config.php";

$my_uid = $_GET['my_uid'];
$friend_uid = $_GET['friend_uid'];



      
        $result = updateSql("DELETE FROM `friend_requests`  WHERE 
      (`friend_requests`.`sender_uid` = '$my_uid' AND `friend_requests`.`receiver_uid` = '$friend_uid') OR 
      (`friend_requests`.`sender_uid` = '$friend_uid' AND `friend_requests`.`receiver_uid` = '$my_uid');"); 
          
          
      


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
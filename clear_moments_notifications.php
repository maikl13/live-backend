<?php
include "config.php";

$user_uid = $_GET['user_uid'];
$result = updateSql("UPDATE `moments_notifications` SET `cleared` = '1' WHERE `moments_notifications`.`to_user` = '$user_uid';");
 
          

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
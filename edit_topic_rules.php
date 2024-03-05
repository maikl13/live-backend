<?php
include "config.php";

$uid =$_GET['uid'];
$value =$_GET['value'];
 
$result = updateSql("UPDATE `topics_for_posts` SET `rules` = '$value' WHERE `topics_for_posts`.`topic_host_uid`='$uid';");
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";


$uid= $_GET['user'];
$myUID = $_GET['myUID'];
 
 $topic=readRowFromSql("SELECT `topics_for_posts`.`id` FROM `topics_for_posts` WHERE `topics_for_posts`.`topic_host_uid`='$myUID'", true)['id'];

 
$result = updateSql("DELETE FROM `topics_blocked_users` WHERE `topics_blocked_users`.`topic` = '$topic' AND  `topics_blocked_users`.`blocked_user` = '$uid'" );
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
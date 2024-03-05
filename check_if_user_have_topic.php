<?php
include "config.php";

$uid =$_GET['uid'];
 $found=readRowFromSql("SELECT `topics_for_posts`.`id` FROM `topics_for_posts` WHERE  `topics_for_posts`.`topic_host_uid`='$uid'", true); 
 $yes=$found['id']!=null;
echo json_encode($yes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
<?php
include "config.php";

$uid =$_GET['uid'];
 $found=readRowFromSql("SELECT `create_topic_request`.`id` FROM `create_topic_request` WHERE  `create_topic_request`.`creator`='$uid'", true); 
 $yes=$found['id']!=null;
echo json_encode($yes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
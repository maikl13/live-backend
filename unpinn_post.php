<?php
include "config.php";

 
$post = $_GET['post'];
$result=false;
$postData=readRowFromSql("SELECT `posts`.`topic` FROM `posts` WHERE `posts`.`id`='$post'", true);
 $postTopic=$postData['topic'];
 if($postTopic!=null&&$postTopic!='NULL'&&$postTopic!='null'){
       $result = updateSql("UPDATE `topics_for_posts` SET `pinned_post` = NULL WHERE `topics_for_posts`.`id` = $postTopic;");     
 
 }
 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
<?php
include "config.php";
include "notifications_manager.php";

 
$post_id = $_GET['post_id'];
$text = $_GET['text'];
$reply_to = $_GET['reply_to'];
$publisher_uid = $_GET['publisher_uid'];
$parent_comment_id = $_GET['parent_comment_id'];

/*
 $result = updateSql("INSERT INTO `comments` 
 (`id`, `text`, `post_id`, `publisher_uid`, `datetime`, `reply_to`, `parent_comment_id`) VALUES 
 (NULL, '$text', '$post_id', '$publisher_uid', CURRENT_TIMESTAMP, $reply_to, '$parent_comment_id');");
*/
/*

*/
 
if($reply_to==null){
   $result = updateSql("INSERT INTO `comments` 
 (`id`, `text`, `post_id`, `publisher_uid`, `datetime`, `reply_to`, `parent_comment_id`) VALUES 
 (NULL, '$text', '$post_id', '$publisher_uid', CURRENT_TIMESTAMP, NULL, NULL);");  
 
 $to_user= readRowFromSql("SELECT `posts`.`publisher_uid` FROM `posts` WHERE `posts`.`id`='$post_id'", true)['publisher_uid'];
}else{
         $result = updateSql("INSERT INTO `comments` 
 (`id`, `text`, `post_id`, `publisher_uid`, `datetime`, `reply_to`, `parent_comment_id`) VALUES 
 (NULL, '$text', '$post_id', '$publisher_uid', CURRENT_TIMESTAMP, '$reply_to', '$parent_comment_id');");
 
$to_user= readRowFromSql("SELECT `comments`.`publisher_uid` FROM `comments` WHERE `comments`.`id`='$parent_comment_id'", true)['publisher_uid'];
}
 

$type=$reply_to==null?'comment_post':'reply_comment';
sendNotification( $to_user, $publisher_uid,  $type,   $post_id,   $parent_comment_id);



          

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";
include "notifications_manager.php";

$comment_id = $_GET['comment_id'];
$user_uid = $_GET['user_uid'];



$liked = readRowFromSql("SELECT * FROM `comments_likes` WHERE `comments_likes`.`comment_id`='$comment_id' AND `comments_likes`.`user_uid`='$user_uid'", true);


if($liked==null||$liked=""){
      $result = updateSql("INSERT INTO `comments_likes` (`id`, `comment_id`, `user_uid`) VALUES (NULL, '$comment_id', '$user_uid');");
      
      $post_id=readRowFromSql("SELECT `comments`.`post_id` FROM `comments` WHERE `comments`.`id`='$comment_id'", true)['post_id'];
      $to_user= readRowFromSql("SELECT `comments`.`publisher_uid` FROM `comments` WHERE `comments`.`id`='$comment_id'", true)['publisher_uid'];
      sendNotification( $to_user, $user_uid,  'like_comment',   $post_id,   $comment_id);
}else{
      $result = updateSql("DELETE FROM `comments_likes` WHERE `comments_likes`.`comment_id`='$comment_id' AND `comments_likes`.`user_uid`='$user_uid'");
}


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
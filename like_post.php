<?php
 include "config.php";
include "notifications_manager.php";


$post_id = $_GET['post_id'];
$user_uid = $_GET['user_uid'];



$liked = readRowFromSql("SELECT * FROM `posts_likes` WHERE `posts_likes`.`post_id`='$post_id' AND `posts_likes`.`user_uid`='$user_uid'", true);


if($liked==null||$liked=""){

      $result = updateSql("INSERT INTO `posts_likes` (`id`, `post_id`, `user_uid`) VALUES (NULL, '$post_id', '$user_uid');");
      
      
 $to_user= readRowFromSql("SELECT `posts`.`publisher_uid` FROM `posts` WHERE `posts`.`id`='$post_id'", true)['publisher_uid'];
 
   
sendNotification( $to_user, $user_uid,  'like_post',   $post_id,   NULL);

}else{
      $result = updateSql("DELETE FROM `posts_likes` WHERE `posts_likes`.`post_id`='$post_id' AND `posts_likes`.`user_uid`='$user_uid'");
}


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
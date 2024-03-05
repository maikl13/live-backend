<?php
include "config.php";
include "pay.php";
include "notifications_manager.php";

$uid =$_GET['uid'];
$comment =$_GET['comment'];
$commenter =$_GET['commenter'];
 

 
 
 if(payNow($uid,'3','g')){
  addToWallet($commenter,'1','g');
 $result = updateSql("INSERT INTO `comments_rewards` (`id`, `comment`, `rewarder`, `datetime`) VALUES (NULL, '$comment', '$uid', CURRENT_TIMESTAMP);");
 
  $post_id=readRowFromSql("SELECT `comments`.`post_id` FROM `comments` WHERE `comments`.`id`='$comment'", true)['post_id'];
      $to_user= readRowFromSql("SELECT `comments`.`publisher_uid` FROM `comments` WHERE `comments`.`id`='$comment'", true)['publisher_uid'];
      sendNotification( $to_user, $uid,  'reward_comment',   $post_id,   $comment);
      
  echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 }else{
 echo "0";
 }

?>
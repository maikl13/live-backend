<?php
include "config.php";


$comment_id = $_GET['comment_id'];
$user_uid = $_GET['user_uid'];





  
 
   
$sorting= $_GET['sorting'];
$sortCode="";
switch($sorting){
    case 'popular':
        $sortCode='ORDER BY likes_count DESC,`noremal_comments`.`datetime` DESC';
        break;
    case 'latest':
        $sortCode='ORDER BY `noremal_comments`.`datetime` DESC, likes_count DESC';
        break;
        
}



 $replies=getComments($comment_id,$user_uid,$sortCode);

echo json_encode($replies, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);



 

function getComments($comment_id,$user_uid,$sortCode){
      $value = readRowFromSql("SELECT
   user_i_reply_to.full_name as reply_to_fullname,
noremal_comments.*,
`writer`.`full_name`,`writer`.`short_digital_id`,`writer`.`uid`,`writer`.`profile_pic`,`writer`.`gender`,
EXISTS (SELECT * FROM `comments_likes` all_the_likes_on_this_comment WHERE all_the_likes_on_this_comment.`comment_id`
=noremal_comments.id AND all_the_likes_on_this_comment.`user_uid`='$user_uid') AS liked,
count(DISTINCT `the_comment_likes`.`id`) AS likes_count,
EXISTS (SELECT * FROM `comments_rewards` all_the_rewards_on_this_comment WHERE all_the_rewards_on_this_comment.`comment`
=noremal_comments.id AND all_the_rewards_on_this_comment.`rewarder`='$user_uid') AS rewarded,
count(DISTINCT `the_comment_rewards`.`id`) AS rewards_count
 FROM `comments` noremal_comments
INNER JOIN `users` writer  ON noremal_comments.`publisher_uid` =`writer`.`uid`  
LEFT OUTER JOIN `comments_likes` the_comment_likes  ON the_comment_likes.`comment_id`=noremal_comments.`id`
LEFT OUTER JOIN `comments_rewards` the_comment_rewards  ON the_comment_rewards.`comment`=noremal_comments.`id`


LEFT OUTER JOIN `comments` comment_i_reply_to  ON comment_i_reply_to.`id`=noremal_comments.`reply_to`
LEFT OUTER JOIN `users` user_i_reply_to  ON user_i_reply_to.`uid`=`comment_i_reply_to`.`publisher_uid`

WHERE  noremal_comments.parent_comment_id =$comment_id
GROUP BY noremal_comments.id
$sortCode 
", false);

foreach($value as $oneComment){
    $formatedComment['id']=$oneComment['id'];
    $formatedComment['text']=$oneComment['text'];
    $formatedComment['post_id']=$oneComment['post_id'];
    $formatedComment['reply_to']=$oneComment['reply_to'];
    $formatedComment['reply_to_fullname']=$oneComment['reply_to_fullname'];
    $formatedComment['liked']=$oneComment['liked'];
    $formatedComment['likes_count']=$oneComment['likes_count'];
      $formatedComment['rewarded']=$oneComment['rewarded'];
    $formatedComment['rewards_count']=$oneComment['rewards_count'];
    $formatedComment['datetime']=$oneComment['datetime'];
    $publisher['publisher_uid']=$oneComment['publisher_uid'];
    $publisher['full_name']=$oneComment['full_name'];
    $publisher['uid']=$oneComment['uid'];
    $publisher['profile_pic']=$oneComment['profile_pic'];
    $publisher['gender']=$oneComment['gender'];
    $publisher['short_digital_id']=$oneComment['short_digital_id'];
    $formatedComment['writer']=$publisher;
    $result1[]=$formatedComment;
}

   return $result1;    
   }
   
   

        


?>
<?php
include "config.php";


$post_id = $_GET['post_id'];
$user_uid = $_GET['user_uid'];

$commentWHERE="`comments`.`reply_to` is null";
$sorting= $_GET['sorting'];


$sortCode="";
switch($sorting){
    case 'popular':
        $sortCode='ORDER BY likes_count DESC, `comments`.`datetime` DESC';
        break;
    case 'latest':
        $sortCode='ORDER BY `comments`.`datetime` DESC, likes_count DESC';
        break;
        
}
$comments=getComments($post_id,$commentWHERE,$user_uid,$sortCode);
foreach($comments as $comment){
    $commentID=$comment['id'];
    $firstReplytWHERE="`comments`.`reply_to` = $commentID";
    $firstReply=getComments($post_id,$firstReplytWHERE,$user_uid,$sortCode)[0];
    $comment['first_reply']=$firstReply;
    $result[]=$comment;

     
}


 
function getComments($post_id,$where,$user_uid,$sortCode){
      $value = readRowFromSql("SELECT
`comments`.*,
`writer`.`full_name`,`writer`.`short_digital_id`,`writer`.`uid`,`writer`.`profile_pic`,`writer`.`gender`,
 `writer`.`current_premium_subscription`,
  `writer`.`current_vip_subscription`,
EXISTS (SELECT * FROM `comments_likes` all_the_likes_on_this_comment WHERE all_the_likes_on_this_comment.`comment_id`=
comments.id AND all_the_likes_on_this_comment.`user_uid`='$user_uid') AS liked,
count(DISTINCT `the_comment_likes`.`id`) AS likes_count,
EXISTS (SELECT * FROM `comments_rewards` all_the_rewards_on_this_comment WHERE all_the_rewards_on_this_comment.`comment`
=comments.id AND all_the_rewards_on_this_comment.`rewarder`='$user_uid') AS rewarded,
count(DISTINCT `the_comment_rewards`.`id`) AS rewards_count
 FROM `comments` 
INNER JOIN `users` writer  ON `comments`.`publisher_uid` =`writer`.`uid`  
LEFT OUTER JOIN `comments_likes` the_comment_likes  ON the_comment_likes.`comment_id`=`comments`.`id`
LEFT OUTER JOIN `comments_rewards` the_comment_rewards  ON the_comment_rewards.`comment`=comments.`id`
 
WHERE  `comments`.`post_id`='$post_id' AND $where
GROUP BY comments.id
 $sortCode  
", false);


foreach($value as $oneComment){
    $formatedComment['id']=$oneComment['id'];
    $formatedComment['text']=$oneComment['text'];
    $formatedComment['post_id']=$oneComment['post_id'];
    $formatedComment['reply_to']=$oneComment['reply_to'];
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
 
    $publisher['current_premium_subscription']=$oneComment['current_premium_subscription'];
    $publisher['current_vip_subscription']=$oneComment['current_vip_subscription'];
    
    $formatedComment['writer']=$publisher;
    $result1[]=$formatedComment;
}
   return $result1;    
   }

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        


?>
<?php
include "config.php";

$followed_uid = $_GET['followed_uid'];
$follower_uid = $_GET['follower_uid'];

 $is_blocked = readRowFromSql("SELECT `blocked_users`.`id`
 FROM `blocked_users` 
 WHERE 
( `blocked_users`.`blocker`='$followed_uid'
 AND `blocked_users`.`blocked`='$follower_uid' )
 OR 
 (
  `blocked_users`.`blocker`='$follower_uid'
 AND `blocked_users`.`blocked`='$followed_uid' 
 )
 
 ", true)['id'];
 if($is_blocked==null){
     $following = readRowFromSql("SELECT * FROM `followers` WHERE `followers`.`followed_uid`='$followed_uid' AND `followers`.`follower_uid`='$follower_uid'", true);


if($following==null||$following=""){
     $myCurrentfollowsCount=getMyCurrentfollowsCoun($follower_uid);
$ceillingCount=getCeillingCount($follower_uid); 
  
$result=array();
 if($ceillingCount==$myCurrentfollowsCount){
        $message= "userReachedFollowsCeiling";
           $succeeded=false;
           $result['message']=$message;
$result['succeeded']=$succeeded;
    }else{
        $following = readRowFromSql("SELECT * FROM `followers` WHERE `followers`.`followed_uid`='$followed_uid' AND `followers`.`follower_uid`='$follower_uid'", true);
if($following==null||$following=""){
      $success= updateSql("INSERT INTO `followers` (`id`, `follower_uid`, `followed_uid`, `datetime`) VALUES (NULL, '$follower_uid', '$followed_uid', CURRENT_TIMESTAMP);");
    $message= "success";
          
    $result['message']=$message;
$result['succeeded']=true;
}else{
    
     $message= "already following";
           $succeeded=false;
           $result['message']=$message;
$result['succeeded']=$succeeded;
}
    }
      
      
      
      
}else{
     updateSql("DELETE FROM `followers` WHERE `followers`.`followed_uid`='$followed_uid' AND `followers`.`follower_uid`='$follower_uid'");
    
           $result['message']="succeeded";
$result['succeeded']=true;
}

 }else{
    
$result['succeeded']=false;
$result['message']="Can not follow thia users because you have blocked each other";
 }

function getMyCurrentfollowsCoun($user_uid){
$count = readRowFromSql("SELECT COUNT(followers.id)  as COUNT FROM `followers` WHERE `followers`.`follower_uid`='$user_uid'", true)['COUNT'];
   return $count;
}
function getCeillingCount($user_uid){
    //get premium data
  $user_premium_subscription=readRowFromSql("SELECT `users`.`current_premium_subscription` FROM `users` WHERE 
`users`.`uid`='$user_uid'", true)['current_premium_subscription'];
  
   if($user_premium_subscription!=null){
       
       $getCountAccordingToPremium = readRowFromSql("SELECT `premium_subscription`.`max_followers_num`  
       FROM `premium_subscription` WHERE `premium_subscription`.`id`= '$user_premium_subscription'
", true);
$countAccordingToPremium=$getCountAccordingToPremium['max_followers_num'];
return $countAccordingToPremium;
   }else{
       return 1000; 
   } 
   
}
          

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
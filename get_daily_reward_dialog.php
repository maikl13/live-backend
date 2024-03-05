<?php
include "config.php";


$user_uid =$_GET['user_uid'];
 
 $result;
 
 
 $usersDailyReward = readRowFromSql("SELECT users_daily_reward.streak_day,
 CASE WHEN CURDATE()= `users_daily_reward`.`last_reward_date`
 THEN 1 ELSE 0 
 END as rewarded_today,
 CASE WHEN CURDATE() <= date_add(`users_daily_reward`.`last_reward_date` ,interval 1 day)
 THEN 1 ELSE 0 END as in_streak FROM `users_daily_reward` WHERE `users_daily_reward`.`user`='$user_uid'  
", true);
 
 if($usersDailyReward!=null){
      if(!$usersDailyReward['in_streak']||$usersDailyReward['streak_day']==7){
      $updateDoingCountAndLastTime = updateSql("UPDATE `users_daily_reward` SET 
   `streak_day` ='0' WHERE `users_daily_reward`.`user`='$user_uid' ");
 }
 }

if($usersDailyReward==null||!$usersDailyReward['in_streak']){
    $result['streak_day']=0;
    $result['rewarded_today']=0;
}else{
    $result=$usersDailyReward;
}
 

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
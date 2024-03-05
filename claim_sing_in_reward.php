<?php
include "config.php";
include "pay.php";



 
$user_uid = $_GET['user_uid'];
 


 $streak_day = readRowFromSql("SELECT  users_daily_reward.streak_day 
        FROM `users_daily_reward`
       WHERE `users_daily_reward`.`user`='$user_uid'       
", true)['streak_day'];

$updateDoingCountAndLastTime=0;
if($streak_day==null){
     $updateDoingCountAndLastTime = updateSql("INSERT INTO `users_daily_reward`
     (`id`, `user`, `last_reward_date`, `streak_day`) VALUES 
     (NULL, '$user_uid', CURDATE(), '1')");
}else{
    $newStreak_day;
   if($streak_day==7){
    $newStreak_day=0;
}else{
    $newStreak_day=$streak_day+1;
} 


if($streak_day==null){
    $day=1;
}else{
    $day=$streak_day+1;
}
    if ($day == 7) {
         $crystal_or_golds_random= rand(0,1);
   $currency_type=$crystal_or_golds_random==0?'g':'c';
 
    } else if ($day == 1 || $day == 3 || $day == 4 || $day == 6) {
      $currency_type ='c';
 
    } else {
     $currency_type ='g';
    }


 $updateDoingCountAndLastTime = updateSql("UPDATE `users_daily_reward` SET `last_reward_date` = CURDATE(),
   `streak_day` ='$newStreak_day' WHERE `users_daily_reward`.`user`='$user_uid' ");
}

 $isVIP = readRowFromSql("SELECT 
users. `current_vip_subscription`
FROM users
WHERE `users`.`uid`= '$user_uid'
", true)['current_vip_subscription']!=null;
 
 $crystal_or_golds_value= rand(1,15);
 if($isVIP){
      $finalRewardValue=$crystal_or_golds_value*2;
 }else{
       $finalRewardValue=$crystal_or_golds_value;
 }

addToWallet($user_uid,$finalRewardValue,$currency_type);
 
 $result['reward_value']=$crystal_or_golds_value;
  $result['reward_type']=$currency_type;
    $result['day']=$day;
  
  
 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);




?>
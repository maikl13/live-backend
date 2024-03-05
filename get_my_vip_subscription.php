<?php
include "config.php";
include "vip_manager.php";

$user =$_GET['user'];
 
  
$curren_subscriptions_data= readRowFromSql("SELECT `vip_subscriptions`.`id`,`vip_subscriptions`.`required_points` ,
`users_vip_points_tracker`.points  as current_points
FROM `users`
LEFT OUTER JOIN `vip_subscriptions`  ON `vip_subscriptions`.`id`=`users`.current_vip_subscription

LEFT OUTER JOIN `users_vip_points_tracker` ON `users_vip_points_tracker`.`user` = `users`.`uid`
WHERE users.uid = '$user'", true);

if($curren_subscriptions_data['id']==null){
    $curren_subscriptions_data['required_points']=0;
      $curren_subscriptions_data['id']=0;
    
}
if($curren_subscriptions_data['current_points']==null){
   $curren_subscriptions_data['current_points']=0; 
}
$nextLevelID=$curren_subscriptions_data['id']+1;
$next_level_required_points= readRowFromSql("SELECT `vip_subscriptions`.`required_points`  FROM `vip_subscriptions` WHERE `vip_subscriptions`.`id` = $nextLevelID", true)['required_points'];

$progress=1;
 if($next_level_required_points!=null){
   
    $progress=$curren_subscriptions_data['current_points']/$next_level_required_points;
}  

 
$curren_subscriptions_data['next_level_required_points']=$next_level_required_points;
 $curren_subscriptions_data['progress']=$progress;
 unset($curren_subscriptions_data['required_points']);
 
echo json_encode($curren_subscriptions_data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
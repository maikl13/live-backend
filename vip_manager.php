<?php
 
 
function subscriptionExpiration($user){

 $update_history= updateSql("  INSERT INTO `vip_subscription_history` (`id`, `user_uid`, `action_type`, `action_date`, `subscription_level`) VALUES (NULL, '$user', 'Expiration', NOW(),$sub_to); ");
      $update_users= updateSql("UPDATE `users` SET `current_vip_subscription` = NULL WHERE `users`.`uid`='$user'");
       resetPoints($user);
}
  function  sub($user,$sub_to,$action_type){
        $update_history= updateSql("  INSERT INTO `vip_subscription_history` (`id`, `user_uid`, `action_type`, `action_date`, `subscription_level`) VALUES (NULL, '$user', '$action_type', NOW(),$sub_to); ");
       
         $update_users= updateSql("UPDATE `users` SET `current_vip_subscription` = $sub_to WHERE `users`.`uid`='$user'");
       resetPoints($user);
    }
function    resetPoints($user){
      $reset_points= updateSql("UPDATE `users_vip_points_tracker` 
    SET `points` = '0' , `started_accumulating_at`= NOW() WHERE `users_vip_points_tracker`.`user` = '$user' ;");
    }
    
    
    
 function   earnVipPoints($user,$price){
    $vipPointsToBeAdded=$price*10;
    
     $myPointsCheck =readRowFromSql("SELECT `id` FROM `users_vip_points_tracker` WHERE `users_vip_points_tracker`.`user` ='$user'",true  );
     if($myPointsCheck==null){
         $update_points= updateSql("INSERT INTO `users_vip_points_tracker` (`user`, `points`, `started_accumulating_at`, `id`) VALUES 
         ('$user', '$vipPointsToBeAdded',NOW(), NULL);");
     }else{
          $update_points= updateSql("UPDATE `users_vip_points_tracker` SET `points` = `points`+$vipPointsToBeAdded WHERE `users_vip_points_tracker`.`user` ='$user';");

     }

    

    //check for any Upgrade/InitialSubscription
     $current_sub_data= readRowFromSql("SELECT `vip_subscriptions`.`required_points`,`vip_subscriptions`.`id` FROM `vip_subscriptions`  INNER JOIN `users` ON `users`.`current_vip_subscription`= `vip_subscriptions`.`id` WHERE `users`.`uid`='$user'",true  );
     
$current_sub_points=$current_sub_data['required_points'];
$current_sub=$current_sub_data['id'];    

      
$current_points= readRowFromSql("SELECT points
    FROM users_vip_points_tracker WHERE user='$user'",true)['points'];
         
    if($current_points==null){$current_points=0;}
  $sub_to= readRowFromSql("SELECT `required_points` , `id` FROM `vip_subscriptions` WHERE `required_points` >=$current_points ORDER BY `vip_subscriptions`.`required_points`DESC LIMIT 1",true )['id']; 
   if($sub_to!=null){
       if($current_sub_data!=null&&$sub_to>$current_sub){
         sub($user,$sub_to,'Upgrade');
} else{
        sub($user,$sub_to,'InitialSubscription');
    }   
   }
     
     
 }
 
 
 ?>
 


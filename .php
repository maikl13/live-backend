<?php
include "config.php";
include "vip_manager.php";

try {
  
    // Query the database to retrieve users with scheduled subscription changes
    $sql = "SELECT user,points
    FROM users_vip_points_tracker WHERE DATEDIFF(Now(),started_accumulating_at) =90";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user = $row['user'];
        $current_points=$row['points'];
      $finishedToday=$row['finishedToday'];
       
      $current_sub_data= readRowFromSql("SELECT `vip_subscriptions`.`required_points`,`vip_subscriptions`.`id` FROM `vip_subscriptions`  INNER JOIN `users` ON `users`.`current_vip_subscription`= `vip_subscriptions`.`id` WHERE `users`.`uid`='$user'",true
    );
    $current_sub_points=$current_sub_data['required_points'];
    $current_sub=$current_sub_data['id'];
     $sub_to= readRowFromSql("SELECT `required_points` , `id` FROM `vip_subscriptions` WHERE `required_points` >=$current_points ORDER BY `vip_subscriptions`.`required_points`DESC LIMIT 1",true )['id'];
    
  if($sub_to!=null){
      if($current_sub<$sub_to){
      
              sub($user,$sub_to,'Downgrade');
      }
       if($current_sub==$sub_to){
            sub($user,$sub_to,'Renewal');
           
      }
      
        
 

   
  }else{
      subExpiration($user,$current_sub);
  }
   
    
       }
} catch (PDOException $e) {
    // Handle database errors
    echo "Error processing subscriptions: " . $e->getMessage();
}

?>
<?php
include "premium_manager.php";
 
try {
  
    // Query the database to retrieve users with scheduled subscription changes
    $sql = "SELECT user_uid, next_subscription,
    DATEDIFF(Now(),subscription_date) =29 as isToday 
    FROM users_premium_subscriptions WHERE next_subscription IS NOT NULL";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $user_uid = $row['user_uid'];
      $isToday=$row['isToday'];
       $nextSubscription=$row['next_subscription'];
      
      if($isToday){
         
            // Apply the scheduled change (e.g., update subscription level in Users_Subscriptions table)
            // Log the change in Subscription_History table
            //update users table
               // Remove the scheduled change (set next_subscription to NULL)

               if($nextSubscription=='cancellation'){
                    $success=subscriptionCancellation($user_uid);
               }else{
                    $success=subscribeToPremium($user_uid,$nextSubscription);
               }
         
           
      
    }}
} catch (PDOException $e) {
    // Handle database errors
    echo "Error processing subscriptions: " . $e->getMessage();
}

?>
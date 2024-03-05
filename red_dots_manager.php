<?php
 
 

function thereIsUnseenNotifications($user) {
    
    $unseen = readRowFromSql("SELECT `moments_notifications`.`id` FROM `moments_notifications` 
LEFT OUTER JOIN `users_moments_last_check_date` ON `users_moments_last_check_date`.`user`=`moments_notifications`.`to_user`
WHERE  `moments_notifications`.`datetime`>`users_moments_last_check_date`.`moments_last_check_date`
AND `moments_notifications`.`to_user`='$user'
",true );
    if($unseen==null){
            return false;

    }else{
   
        return true;
    }
    
}
 function thereIsUnseenDoneTasks($user) {
    
    $unseen_done_improvement_tasks = readRowFromSql("SELECT `improvement_tasks`.`id`
FROM `improvement_tasks`
INNER  JOIN `users_done_onetime_tasks` ON `users_done_onetime_tasks`.`user` = '$user' AND 
`users_done_onetime_tasks`.`task`=`improvement_tasks`.`id`
WHERE 
  `users_done_onetime_tasks`.`profit_added_to_wallet`='0' 
 AND
 users_done_onetime_tasks.doing_count=improvement_tasks.repetitions_number
",true );
    $unseen_done_daily_tasks = readRowFromSql("SELECT `dialy_tasks`.`id`
 
FROM `dialy_tasks` LEFT OUTER JOIN `tasks_last_time` ON `tasks_last_time`.`user` = '$user' AND  `tasks_last_time`.`task`=`dialy_tasks`.`id`
WHERE
 TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP, `tasks_last_time`.`datetime`))/3600 < 24
AND
 `tasks_last_time`.`last_profit_added_to_wallet`='0'
",true );
    if($unseen_done_improvement_tasks==null&&$unseen_done_daily_tasks==null){
            return false;

    }else{
 
     echo $unseen_done_improvement_tasks;
   
        return true;
    }
    
}
?>
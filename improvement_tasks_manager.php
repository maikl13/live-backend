<?php
 


function onDone($task,$user_uid,$echo_result){
    
$userDoneItBefore=(readRowFromSql("SELECT  users_done_onetime_tasks.doing_count,
CASE
            WHEN users_done_onetime_tasks.doing_count=improvement_tasks.repetitions_number
               THEN 1
               ELSE 0
       END as completely_done
FROM `users_done_onetime_tasks` 
INNER JOIN improvement_tasks ON improvement_tasks.id=users_done_onetime_tasks.task
WHERE `users_done_onetime_tasks`.`user`='$user_uid' AND `users_done_onetime_tasks`.`task`='$task'", true));
if($userDoneItBefore==null){
 
  $updateDoingCountAndLastTime = updateSql("INSERT INTO `users_done_onetime_tasks`
  (`id`, `user`, `task`, `datetime`, `profit_added_to_wallet`, `doing_count`)
  VALUES (NULL, '$user_uid', '$task', CURRENT_TIMESTAMP, '0', '1');");     
  if($echo_result){
    echo "success";
  }
   
}else if($userDoneItBefore['completely_done']){
    if($echo_result){
        echo "Already Done";
    }
     
 
}else{
  $updateDoingCountAndLastTime = updateSql("UPDATE `users_done_onetime_tasks` SET `doing_count` = doing_count+1 
  WHERE `users_done_onetime_tasks`.`user`= '$user_uid' AND `users_done_onetime_tasks`.`task`='$task'");     
    if($echo_result){
        echo "success";
    }
   
}

}

?>
<?php
include "config.php";




$task = $_GET['task'];
$user_uid = $_GET['user_uid'];


$userDoneItBefore=(readRowFromSql("SELECT  users_done_onetime_tasks.doing_count,
CASE
            WHEN users_done_onetime_tasks.doing_count=improvement_tasks.repetitions_number
               THEN 1
               ELSE 0
       END as completely_done
FROM `users_done_onetime_tasks` 
INNER JOIN improvement_tasks ON improvement_tasks.id=users_done_onetime_tasks.task
WHERE `users_done_onetime_tasks`.`user`='$user_uid' AND `users_done_onetime_tasks`.`task`='$task'", true));
if($userDoneItBefore!=null){
  if($userDoneItBefore['doing_count']==1){
     $updateDoingCountAndLastTime = updateSql("DELETE FROM `users_done_onetime_tasks` WHERE
     `users_done_onetime_tasks`.`user`= '$user_uid' AND `users_done_onetime_tasks`.`task`='$task'");     
    echo "success";
}else{
  $updateDoingCountAndLastTime = updateSql("UPDATE `users_done_onetime_tasks` SET `doing_count` = doing_count-1 
  WHERE `users_done_onetime_tasks`.`user`= '$user_uid' AND `users_done_onetime_tasks`.`task`='$task'");     
    echo "success";
}
    
}
  
 



?>
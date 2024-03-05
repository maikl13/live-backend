<?php
include "config.php";




$task = $_GET['task'];
$user_uid = $_GET['user_uid'];

$state  = readRowFromSql("SELECT   
  CASE
   WHEN TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP, `tasks_last_time`.`datetime`))/3600 < 24
    THEN 1
    ELSE 0
    END as done
FROM `dialy_tasks` LEFT OUTER JOIN `tasks_last_time` ON `tasks_last_time`.`user` = '$user_uid' AND  `tasks_last_time`.`task`=`dialy_tasks`.`id`
WHERE `dialy_tasks`.`id` ='$task'
", true);
$user_done_it_today;
if($state==null){
    $user_done_it_today=false;
 
}else{
  
    $user_done_it_today=$state['done']==1?true:false;
    
}
 
if($user_done_it_today){
     echo "Already Done";

}else{

$userDoneItBefore=(readRowFromSql("SELECT  `tasks_last_time`.`id` FROM `tasks_last_time` 
WHERE `tasks_last_time`.`user`='$user_uid' AND `tasks_last_time`.`task`='$task'", true));
if($userDoneItBefore!=null){
 
     $updateDoingCountAndLastTime = updateSql("UPDATE `tasks_last_time` SET `doing_count` = doing_count+1 ,datetime=CURRENT_TIME
WHERE `tasks_last_time`.`user`='$user_uid' AND `tasks_last_time`.`task`='$task'");
     
}else{
     $updateDoingCountAndLastTime = updateSql("INSERT INTO `tasks_last_time` (`id`, `task`, `user`, `datetime`, `doing_count`) 
     VALUES (NULL, '$task', '$user_uid', CURRENT_TIMESTAMP,'1');");     
}
 
 
echo "success";

}
 



?>
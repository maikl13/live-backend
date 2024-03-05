<?php
include "config.php";

    $user_uid =$_GET['user_uid'];
    
    $improvement_tasks = readRowFromSql("SELECT `improvement_tasks`.*,`users_done_onetime_tasks`.`datetime` last_time,
 `users_done_onetime_tasks`.`profit_added_to_wallet` ,users_done_onetime_tasks.doing_count
  ,CASE
            WHEN users_done_onetime_tasks.doing_count=improvement_tasks.repetitions_number
               THEN 1
               ELSE 0
       END as completely_done
FROM `improvement_tasks`

LEFT OUTER JOIN `users_done_onetime_tasks` ON `users_done_onetime_tasks`.`user` = '$user_uid' AND 
`users_done_onetime_tasks`.`task`=`improvement_tasks`.`id`
WHERE 
  `users_done_onetime_tasks`.`profit_added_to_wallet`!='1' OR  `users_done_onetime_tasks`.`profit_added_to_wallet` is NULL", false);

   
echo json_encode($improvement_tasks, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";

  $user_uid =$_GET['user_uid'];
$premium_subscriptions = readRowFromSql("SELECT `dialy_tasks`.*,`tasks_last_time`.`datetime` last_time,
 `tasks_last_time`.`last_profit_added_to_wallet`,
  CASE
            WHEN TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP, `tasks_last_time`.`datetime`))/3600 < 24
               THEN 1
               ELSE 0
       END as done
FROM `dialy_tasks` LEFT OUTER JOIN `tasks_last_time` ON `tasks_last_time`.`user` = '$user_uid' AND  `tasks_last_time`.`task`=`dialy_tasks`.`id`
", false);

   


echo json_encode($premium_subscriptions, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";





$user_uid = $_GET['user_uid'];
$topic = $_GET['topic'];
$search_word = $_GET['search_word'];
 
  
   $results = readRowFromSql("  
  SELECT `topics_blocked_users`.`datetime`,
users.id,
users.uid,
users.full_name,
users.profile_pic,
users.level,
users.gender,
admin.full_name as admin_name
FROM `topics_blocked_users` 
INNER JOIN `users` users  ON users.`uid`=`topics_blocked_users`.`blocked_user`
INNER JOIN `users` admin  ON admin.`uid`=`topics_blocked_users`.`admin`
WHERE `topics_blocked_users`.`topic` ='$topic' AND   ( users.full_name   LIKE '%$search_word%'||users.short_digital_id   LIKE '%$search_word%') 
GROUP BY  users.uid", false);

 


echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
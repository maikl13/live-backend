<?php
include "config.php";
 





$user_uid = $_GET['user_uid'];
 
   $results = readRowFromSql(" SELECT 
COUNT(viewed_users_search_results.id) as views_count,
  
   users.uid,
 users.gender,
 users.bio,
 users.full_name,
 users.profile_pic
FROM `viewed_users_search_results`
INNER JOIN users on users.uid = viewed_users_search_results.user_uid
 
GROUP BY viewed_users_search_results.user_uid
ORDER BY views_count DESC
", false);

 
 
echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
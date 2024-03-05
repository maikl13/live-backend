<?php
include "config.php";
 

$user=$_GET['user'];
  $moreThan30days=readRowFromSql(" 
SELECT COUNT(*) > 0 AS result
FROM users
WHERE 
users.uid='$user' AND
DATEDIFF(CURDATE(), join_date) > 30;", true)['result']; 
 
 $result['more_than30days']=$moreThan30days;
   echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
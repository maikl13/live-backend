
<?php
include "config.php";

$user_uid = $_GET['user_uid'];


   $result = updateSql("DELETE FROM `search_history` WHERE `search_history`.`searcher_uid` = '$user_uid'");  
          
      

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>

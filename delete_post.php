<?php
include "config.php";

$post_id = $_GET['post_id'];


   $result = updateSql("DELETE FROM `posts` WHERE `posts`.`id` = $post_id");  
          
      

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
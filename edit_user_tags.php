<?php
include "config.php";

$tags = $_GET['tags'];
$user_uid = $_GET['user_uid'];
$tags_array=json_decode($tags,true);



    $result = updateSql("DELETE FROM `users_tags` WHERE `users_tags`.`user_uid` = '$user_uid'");
   
       
       
  if($tags!=null&&$tags!=""){
         foreach($tags_array as $tag){
        $result_add = updateSql("INSERT INTO `users_tags` (`id`, `user_uid`, `tag_id`) VALUES (NULL, '$user_uid', '$tag');");
        

        
    } 
   }   
 
  


   
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
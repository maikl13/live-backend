<?php
include "config.php";





$user_uid = $_GET['user_uid'];
$search_word = $_GET['search_word'];
 
 

 
   $results = readRowFromSql(" SELECT 
   users.uid,
 users.gender,
 users.bio,
 users.full_name,
 users.profile_pic,
  users.short_digital_id
  FROM `users` 
    WHERE ( users.full_name   ='$search_word'||users.short_digital_id   ='$search_word')AND(
     users.uid!='$user_uid'
    )
GROUP BY  users.uid", false);

      $add_to_history = updateSql("INSERT INTO `search_history` (`id`, `searcher_uid`, `word`,`type`) VALUES (NULL, '$user_uid', '$search_word','users');");


echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
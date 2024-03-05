<?php
include "config.php";





$user_uid = $_GET['user_uid'];
 
   $words = readRowFromSql(" SELECT search_history.word FROM `search_history` WHERE searcher_uid='$user_uid' 
GROUP BY word
", false);

 $results=Array();
 foreach($words as $word){
     $results[]=$word['word'];
 }
echo json_encode($results, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
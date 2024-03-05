<?php
include "config.php";





$user_uid = $_GET['user_uid'];
 $viewed = $_GET['viewed'];
 

      $result = updateSql("INSERT INTO `viewed_rooms_search_results` (`id`, `searcher_uid`, `room_id`) VALUES (NULL, '$user_uid', '$viewed');");


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
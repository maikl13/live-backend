<?php
include "config.php";

$visited_uid = $_GET['visited_uid'];
$visitor_uid = $_GET['visitor_uid'];



$visited_them_before = readRowFromSql("SELECT `users_visitors`.`id` FROM `users_visitors` WHERE `users_visitors`.`visited_uid`='$visited_uid' AND `users_visitors`.`visitor_uid`='$visitor_uid'", true);


if($visited_them_before==null){
      $result = updateSql("INSERT INTO `users_visitors` (`id`, `visited_uid`, `visitor_uid`, `datetime`) VALUES (NULL, '$visited_uid', '$visitor_uid', CURRENT_TIMESTAMP);");
}


          

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
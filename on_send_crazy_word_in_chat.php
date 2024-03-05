<?php
include "config.php";

$id = $_GET['id'];
 
 $result = updateSql("UPDATE `users_sent_crazy_words_cards` SET `done` = `done`+1 WHERE `users_sent_crazy_words_cards`.`id` = $id;");


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
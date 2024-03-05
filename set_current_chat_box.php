<?php
include "config.php";

$uid = $_GET['uid'];
$chat_box = $_GET['chat_box'];

if($chat_box==null||$chat_box=='null'){
 
  $result = updateSql("UPDATE `users` SET `chat_box` = NULL WHERE `users`.`uid`='$uid'");
}else{
  $result = updateSql("UPDATE `users` SET `chat_box` = '$chat_box' WHERE `users`.`uid`='$uid'");
}



echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
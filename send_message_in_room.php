<?php
include "config.php";




$room_id = $_GET['room_id'];
$sender_uid = $_GET['sender_uid'];
$chat_message_type = $_GET['chat_message_type'];
$body  = $_GET['body'];

  
  
 


 $result = InsertAndGetId("INSERT INTO `messages` 
 (`id`, `body`, `sent_datetime`, `room_id`, `chat_message_type`, `sender_uid`) VALUES 
 (NULL, '$body', CURRENT_TIMESTAMP, '$room_id', '$chat_message_type', '$sender_uid');");







echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
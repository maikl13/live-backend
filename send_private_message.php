<?php
include "config.php";


 
$content = $_GET['content'];
$private_conversation_id = $_GET['conversation_id'];
$sender_uid = $_GET['sender_uid'];
$content_type = $_GET['content_type'];

  $voice_duration=NULL;
if($_GET['voice_duration']!=null){
    $voice_duration=$_GET['voice_duration'];
}

  
  
  $timestamp = time();
 
 

 
 $id = InsertAndGetId("
 INSERT INTO `private_messages` (`id`, `content`, `private_conversation_id`,
 `sender_uid`, `content_type`, `datetime`, `seen`, `voice_duration`) VALUES 
 (NULL, '$content', '$private_conversation_id', '$sender_uid', '$content_type', CURRENT_TIMESTAMP, '0', '$voice_duration');");

 
$dataToBeBack['messageId']=$id;
$dataToBeBack['timestamp']=$timestamp;



echo json_encode($dataToBeBack, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
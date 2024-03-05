<?php
include "config.php";
 


$creator_uid = $_GET['creator_uid'];
$title = $_GET['title'];
$image= $_GET['image'];
$description= $_GET['description'];
$room= $_GET['room'];

$start_at= $_GET['start_at'];
$end_at= $_GET['end_at'];

 
  $result = updateSql("
INSERT INTO `events`
(`id`, `title`, `description`, `image`, `creator_uid`, `start_at`, `end_at`, `room`, `creating_datetime`) VALUES
(NULL, '$title', '$description', '$image', '$creator_uid', '$start_at', '$end_at', '$room', CURRENT_TIMESTAMP);");
 
 


 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
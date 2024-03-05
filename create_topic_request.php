<?php
include "config.php";
include "pay.php";



$image= $_GET['image'];
$name = $_GET['name'];
$description= $_GET['description'];
$creator = $_GET['creator'];

 
 $result = updateSql("INSERT INTO `create_topic_request` (`id`,`image`, `name`, `description`, `creator`) VALUES 
 (NULL,'$image', '$name', '$description', '$creator');");


 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
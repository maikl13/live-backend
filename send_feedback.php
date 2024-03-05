<?php
include "config.php";
 



$user = $_GET['user'];
$type= $_GET['type'];
$problem_description = $_GET['problem_description'];
 
 
$images=[];
if($_GET['images']!=null){
    $json =json_decode($_GET['images']);
 foreach($json as $item){
   $images[]=$item;   
    
 }
}
 
 

 $feedback= InsertAndGetId("INSERT INTO `feedback` (`id`,`user`, `type`, `problem_description`) VALUES (NULL,'$user', '$type', '$problem_description');"); 

if (count($images) != 0) {
    foreach($images as $image){
    $result= updateSql("INSERT INTO `feedback_screens` (`id`, `screen`, `feedback`) VALUES (NULL, '$image', '$feedback');"); 
}}

 
 



echo 1;


?>
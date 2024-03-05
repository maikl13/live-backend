<?php
include "config.php";




$post_id = $_GET['post_id'];
$topic = $_GET['topic'];
$privacy = $_GET['privacy'];
$location = $_GET['location'];

 if($topic==null){
    $location="";
     
 }
if($topic==null){
    $topic="NULL";
}else{
    $topic="$topic";
}
$text = $_GET['text'];
$images=[];
if($_GET['images']!=null){
    $json =json_decode($_GET['images']);
 foreach($json as $item){
   $images[]=$item;   
    
 }
}
$mentions=[];
if($_GET['mentions']!=null){
    $json =json_decode($_GET['mentions']);
 foreach($json as $item){
   $mentions[]=$item;   
    
 }
}

 

 $post= updateSql("UPDATE `posts` SET `topic` = $topic ,`text` = '$text',`privacy` = '$privacy' ,`location` = '$location'    WHERE `posts`.`id` = '$post_id';"); 
 
 $deleteOldPhotos= updateSql("DELETE FROM `posts_images` WHERE `posts_images`.`post`='$post_id'"); 

if (count($images) != 0) {
    foreach($images as $image){
    $result= updateSql("INSERT INTO `posts_images` (`id`, `post`, `image`) VALUES (NULL, '$post_id', '$image');"); 
}}

 
    $deleteOldMentionss= updateSql("DELETE FROM `posts_mentions` WHERE `posts_mentions`.`post`='$post_id'"); 
 if(count($mentions) != 0){

  
 foreach($mentions as $mention){
 

    $result2= updateSql("INSERT INTO `posts_mentions` (`id`, `post`, `mention_to`) VALUES (NULL, '$post_id', '$mention');"); 
         
}
}



echo "true";


?>
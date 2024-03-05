<?php
include "config.php";
include "notifications_manager.php";



$publisher_uid = $_GET['publisher_uid'];
$topic = $_GET['topic'];
$privacy = $_GET['privacy'];
$location = $_GET['location'];
$shared_post = $_GET['shared_post'];
$shared_room = $_GET['shared_room'];
if($topic==null){
    $topic="NULL";
}else{
    $topic="$topic";
}
if($shared_post==null){
    $shared_post="NULL";
}else{
 
 
    $shared_post_writer=$_GET['shared_post_write'];
 
  sendNotification( $shared_post_writer, $publisher_uid,  'share_post',   $shared_post,   NULL);
  
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

 

 $post= InsertAndGetId("INSERT INTO `posts` 
  (`id`, `publisher_uid`, `datetime`, `topic`, `text`,`privacy`,`location`,`shared_post`,`shared_room`) VALUES 
  (NULL, '$publisher_uid', CURRENT_TIMESTAMP, $topic, '$text','$privacy','$location',$shared_post,$shared_room)"); 

if (count($images) != 0) {
    foreach($images as $image){
    $result= updateSql("INSERT INTO `posts_images` (`id`, `post`, `image`) VALUES (NULL, '$post', '$image');"); 
}}

 
 
 if(count($mentions) != 0){
    
 foreach($mentions as $mention){
 

    $result2= updateSql("INSERT INTO `posts_mentions` (`id`, `post`, `mention_to`) VALUES (NULL, '$post', '$mention');"); 
         
}
}




echo "true";


?>
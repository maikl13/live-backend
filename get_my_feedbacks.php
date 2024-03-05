<?php
include "config.php";


$user =$_GET['user'];



$feedback = readRowFromSql("SELECT * FROM `feedback` WHERE  `feedback`.`user`='$user'", false);
$stickers_sections = readRowFromSql("SELECT * FROM `stickers_sections` ", false);
 $result=array();
 foreach($feedback as  $item){
     $feedbackId=$item['id'];
     $images= readRowFromSql("SELECT `feedback_screens`.`screen` FROM `feedback_screens` WHERE feedback_screens.feedback ='$feedbackId'", false);
     $imagesList=array();
     foreach($images as $image){
         $imagesList[]=$image['screen'];
     }
     $item['images']=$imagesList;
     $result[]=$item;
 }
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
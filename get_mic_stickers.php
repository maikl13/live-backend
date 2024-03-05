
<?php
include "config.php";


$room_id =$_GET['room_id'];



$stickers = readRowFromSql("SELECT * FROM stickers", false);
$stickers_sections = readRowFromSql("SELECT * FROM `stickers_sections` ", false);
 $result=array();
 foreach($stickers_sections as  $section){
     $stickersOfSection=array();
      foreach($stickers as  $sticker){
          if($sticker['section']==$section['id']){
                $stickersOfSection[]=$sticker;
          }
        
      }
      $section['stickers']=$stickersOfSection ;
     $result[]=$section;
 }
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
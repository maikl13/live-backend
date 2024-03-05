<?php
include "config.php";


$default_profile_photos_sections= readRowFromSql("SELECT * FROM `default_profile_photos_sections`"
, false);

$result=array();
foreach($default_profile_photos_sections as $section){
    $section_id=$section['id'];
$photos= readRowFromSql("SELECT `default_profile_photos`.`id`,`default_profile_photos`.`photo`
FROM `default_profile_photos`
WHERE `default_profile_photos`.`section`= '$section_id'"
, false);
$section['photos']=$photos;

$result[]=$section;



}


   
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
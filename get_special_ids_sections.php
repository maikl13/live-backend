<?php
include "config.php";
///// our real code //////
$all_sections = readRowFromSql("SELECT * FROM `special_ids_sections` ", false);
$result = array();
foreach ($all_sections as $section) {
    $section_id = $section["id"];
   $sub_sections = readRowFromSql("SELECT * FROM `special_ids_sub_sections` WHERE `special_ids_sub_sections`.`father_section`=$section_id ", false);
   $section['sub_patterns']=$sub_sections;
   $result[]=$section;
   
   
}
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>


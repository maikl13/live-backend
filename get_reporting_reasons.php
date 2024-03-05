<?php
include "config.php";


$part =$_GET['reported_part_type'];
 $result=array();
$reporting_reasons = readRowFromSql("SELECT * FROM `reporting_reasons`", 
false);
 
$reporting_reasons_sections = readRowFromSql("
SELECT reporting_reasons_sections.* FROM `reporting_reasons_sections` 
LEFT OUTER JOIN `parts_unique_reporting_reasons_sections`ON `parts_unique_reporting_reasons_sections`.`reason_section` =`reporting_reasons_sections`.`id`

WHERE `reporting_reasons_sections`.`is_unique`=0
OR(
`parts_unique_reporting_reasons_sections`.`part` =  '$part'
AND
`reporting_reasons_sections`.`is_unique`=1
AND `parts_unique_reporting_reasons_sections`.`part` !=  'account'   
)   
", false);


foreach($reporting_reasons_sections as $section){
    $reasons=array();
    foreach($reporting_reasons as $reason){
        if($section['id']==$reason['section']){
                $reasons[]=$reason;
        }}
      $section['reasons']= $reasons;
      $result[]=$section;
}
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";


$result=[];
$all_tags= readRowFromSql("SELECT * FROM `all_tags`"
, false);


   foreach ($all_tags as $tag) {
$tagId=$tag['id'];
$sub_tags= readRowFromSql("SELECT * FROM `sub_tags` WHERE sub_tags.parent_id = '$tagId'"
, false);

$tag["sub_tags"]=$sub_tags;

    $result[]=   $tag;
   }
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
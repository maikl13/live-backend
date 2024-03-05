<?php
include "config.php";


$uid =$_GET['uid'];

$result=array();
$hats= readRowFromSql("SELECT users_hats.stock ,hats.* FROM `hats` 
LEFT OUTER JOIN users_hats ON `hats`.`id`=users_hats.hat AND users_hats.user_uid='$uid'
GROUP BY hats.id"
, false);
foreach($hats as $hat){
    if($hat['stock']==null){
        $hat['stock']=0;
    }
    $result[]=$hat;
}

   
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
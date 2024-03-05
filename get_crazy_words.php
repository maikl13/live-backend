<?php
include "config.php";


$uid =$_GET['uid'];

$result=array();
$crazywords= readRowFromSql("SELECT users_crazywords.stock ,crazy_words.* FROM `crazy_words` 
LEFT OUTER JOIN users_crazywords ON `crazy_words`.`id`=users_crazywords.crazyword AND users_crazywords.user_uid='$uid'
GROUP BY crazy_words.id"
, false);
foreach($crazywords as $crazyword){
    if($crazyword['stock']==null){
        $crazyword['stock']=0;
    }
    $result[]=$crazyword;
}

   
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";
 

$uid =$_GET['uid'];
 
  $result=array();
    $result= readRowFromSql(" SELECT * FROM `gifts_rebates` WHERE `gifts_rebates`.`user`='$uid' ORDER BY `gifts_rebates`.`datetime`
 ", false);

 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
$rebateId =$_GET['rebate_id'];
   
$done=insertGiftRebateValueIntoWallet($uid,$rebateId); 
echo json_encode($done, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);


?>
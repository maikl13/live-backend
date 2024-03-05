<?php
include "config.php";
 
$uid=$_GET['uid'];
 
 $result =   readRowFromSql("select `users`.`account_status` FROM `users` WHERE 
`users`.`uid`= '$uid'", true)['account_status']=='banned';
    


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
<?php
include "config.php";


$adminUid= $_GET['admin'];
$topic = $_GET['topic'];

 
$result = updateSql("DELETE FROM `topics_admins` WHERE `topics_admins`.`topic` = '$topic' AND  `topics_admins`.`admin` = '$adminUid'" );
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
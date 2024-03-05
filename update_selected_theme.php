<?php
include "config.php";


$uid =$_GET['uid'];
$theme_type =$_GET['theme_type'];
$selected_theme =$_GET['selected_theme'];

$key="";
switch($theme_type){
    case "CUSTOM":
        $key="CUSTOM";
        break;
    case "PREMIUM":
         $key="PREMIUM";
        break;
    case "STORE":
        $key="STORE";
        break;
}
$select=readRowFromSql("SELECT `rooms`.`id` FROM `rooms` WHERE `rooms`.`creator_uid`='$uid'", true);
$user_room_id=$select['id'];


 $result = updateSql("UPDATE `rooms` SET `theme`='$selected_theme' ,`theme_type`='$key'  WHERE `rooms`.`id` = '$user_room_id'");


echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
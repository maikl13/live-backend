<?php
include "config.php";


$uid =$_GET['uid'];


$select=readRowFromSql("SELECT `rooms`.`theme` FROM `rooms` WHERE `rooms`.`creator_uid`='$uid'", true);
$user_room_theme=$select['theme'];

$custom_themes = readRowFromSql("SELECT `custom_themes`.* , 
'$user_room_theme'=`custom_themes`.`id` AS is_selected
 
FROM `custom_themes` WHERE `custom_themes`.`creator_uid`='$uid'  
AND `custom_themes`.`available`=1
", false);



echo json_encode($custom_themes, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>

<?php
include "config.php";


$user  =$_GET['user'];
$statue =$_GET['statue'];
 $result = updateSql("UPDATE `users` SET `view_my_related_rooms` = '$statue' WHERE `users`.`uid`='$user';");
 echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
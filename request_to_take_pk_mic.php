<?php
include "config.php";


$battle = $_GET['battle'];
$user = $_GET['user'];
$place_index = $_GET['place_index']; 


$indexIsFree= readRowFromSql("SELECT `user` FROM `pk_mic_requests` WHERE  `place_index` =
	 '$place_index' AND  `battle` ='$battle';", true);
updateSql("DELETE FROM pk_mic_requests WHERE   `pk_mic_requests`.`battle`='$battle' AND  `pk_mic_requests`.`user`='$user'");  
if($indexIsFree==null){
 $result=updateSql("INSERT INTO `pk_mic_requests`
(`id`, `battle`, `user`, `place_index`) VALUES
(NULL, '$battle', '$user', '$place_index');");  
} 
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
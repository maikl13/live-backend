<?php
include "config.php";



$battle = $_GET['battle']; 
 
 //useless
$datetime = new DateTime( "now", new DateTimeZone( "Africa/Cairo" ) );
$now= $datetime->format( 'Y-m-d H:i:s' );
 
$pk_mic_requests= readRowFromSql("SELECT 
`pk_mic_requests`.`user`,
`pk_mic_requests`.`place_index`
FROM `pk_mic_requests` WHERE `pk_mic_requests`.`battle`='$battle'", false);

foreach($pk_mic_requests as $request){
	$curr_place_index=$request['place_index'];
	if($curr_place_index==$x){
		$curr_user=$request['user'];
		$result=updateSql("UPDATE `pk_mic_places` 
SET `user`='$curr_user'
WHERE `place_index`='$curr_place_index' AND `battle`='$battle'");  
	}
}
 
 $result=updateSql(" UPDATE `pk_battles`
 SET 
   `started_at` = NOW()
 WHERE `pk_battles`.`id` = '$battle';");  
 echo json_encode($now, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 
?>
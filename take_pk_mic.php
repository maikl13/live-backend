<?php
include "config.php";


$room_id = $_GET['room_id'];
$battle = $_GET['battle'];
$index = $_GET['index'];
$user_uid = $_GET['user_uid'];
 


$micForSpeceficMembersOnly= readRowFromSql("SELECT `mic_allowed`.`user_uid` FROM `mic_allowed` WHERE room_id=$room_id", true);
if($micForSpeceficMembersOnly!=null){
    $imAllowed= readRowFromSql("SELECT `mic_allowed`.`user_uid` FROM `mic_allowed` WHERE room_id=$room_id AND user_uid='$user_uid'", true);
    $imAllowedToOccupy=$imAllowed!=null;
}else{
    $imAllowedToOccupy=true;
}

if($imAllowedToOccupy){
    $indexIsFree= readRowFromSql("SELECT `user` FROM `pk_mic_places` WHERE 
    `pk_mic_places`.`place_index` =
	 '$index' AND  `pk_mic_places`.`battle` ='$battle';", true);
   $result =  updateSql("UPDATE `pk_mic_places` SET `user` =NULL WHERE `user`='$user_uid'
	  AND  `battle` = '$battle'");  
if($indexIsFree!=null){
 
       $result = updateSql("UPDATE `pk_mic_places` SET `user` = '$user_uid'
        WHERE `pk_mic_places`.`place_index` =
	 '$index' AND  `pk_mic_places`.`battle` ='$battle';"); 
      
     //pk players (for history) INSERT if new to index
     $iWasNeverHereBefore= readRowFromSql("SELECT `pk_players`.`id` FROM `pk_players` WHERE 
     `pk_players`.`user` =  '$user_uid'
     AND  `pk_players`.`battle` ='$battle'  AND  `pk_players`.`index` ='$index';", true)==NULL;

      if($iWasNeverHereBefore){
    
        $resultpk_players=updateSql("INSERT INTO `pk_players` 
        (`id`, `user`, `index`, `golds`, `battle`, `date`) 
        VALUES 
        (NULL, '$user_uid', '$index', '0', '$battle', CURRENT_TIMESTAMP);");  
       
      }


} 
$theResult['succeeded']=$result;
$theResult['message']="";


}else{
 $theResult['succeeded']=false;
$theResult['message']="NotAllowed";
} 

echo json_encode($theResult, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);





?>
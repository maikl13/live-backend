<?php
include "config.php";


$uid =$_GET['uid'];

$result=array();
$voicechangers= readRowFromSql("SELECT users_voice_changers.stock as stock ,voice_changer.* FROM `voice_changer` 
LEFT OUTER JOIN users_voice_changers ON `voice_changer`.`id`=users_voice_changers.voice_changer AND users_voice_changers.user_uid='$uid'
GROUP BY voice_changer.id"
, false);
foreach($voicechangers as $changer){
    if($changer['stock']==null){
        $changer['stock']=0;
    }
    $result[]=$changer;
}

   
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
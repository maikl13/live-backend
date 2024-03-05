<?php
include "config.php";
 
$UPDATE_battles_time= updateSql("UPDATE `pk_battles` SET `remaining_seconds`=`remaining_seconds`-1 WHERE `remaining_seconds`>0");


$done_battles= readRowFromSql("SELECT `pk_battles`.`id` FROM `pk_battles` WHERE `pk_battles`.`started_at` + INTERVAL
 `pk_battles`.`period_in_min` MINUTE < CURDATE() AND `pk_battles`.`ended_at` IS NULL", false);

foreach($done_battles as $done_battle){
	$battle=$done_battle['id'];
 $winner_team= readRowFromSql("SELECT  `pk_battle_teams`.`id` FROM `pk_battle_teams` 
WHERE `pk_battle_teams`.`battle`='$battle'  ORDER BY `pk_battle_teams`.`total_gold` LIMIT 1 ", true)['id'];

if($winner_team!=NULL){
	 
	echo $battle;
	 $result=updateSql("UPDATE `pk_battles` SET `ended_at` = CURRENT_TIMESTAMP, 
	 `ended_by_admin` = 0, `winner_team` = $winner_team 
	 WHERE `pk_battles`.`id` = '$battle';");  
}else{
 
	$result=updateSql("UPDATE `pk_battles` SET `end_at`=CURDATE(),`ended_by_admin`=0  WHERE
	`pk_battles`.`id` ='$battle'");  
}
 
 

 
}

?>
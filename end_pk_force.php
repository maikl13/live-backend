<?php
include "config.php";
 $battle = $_GET['battle'];
  
 
 $winner_team= readRowFromSql("SELECT  `pk_battle_teams`.`id` FROM `pk_battle_teams` 
WHERE `pk_battle_teams`.`battle`='$battle'  ORDER BY `pk_battle_teams`.`total_gold` LIMIT 1 ",
 true)['id'];

//if($winner_team!=NULL){
	 $result=updateSql("UPDATE `pk_battles` SET `ended_at`=CURDATE(),`ended_by_admin`=1 WHERE
	 `pk_battles`.`id` ='$battle'");  
//}

?>
<?php
include "config.php";


$battle = $_GET['battle'];
 
 
$winner_team= readRowFromSql("SELECT  `pk_battle_teams`.`id` FROM `pk_battle_teams` 
WHERE `pk_battle_teams`.`battle`='$battle'  ORDER BY `pk_battle_teams`.`total_gold` LIMIT 1 ", true)['id'];

if($winner_team!=NULL){
	 $result=updateSql("UPDATE `pk_battles` SET `end_at`=CURDATE(),`ended_by_admin`='$ended_by_admin' `winner_team`= '$winner_team' WHERE
`pk_battles`.`id` ='$battle'");  
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

}

?>
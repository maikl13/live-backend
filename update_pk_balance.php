<?php
include "config.php";



$player = $_GET['player']; 
$team = $_GET['team_number']; 
$index = $_GET['index']; 
$battle = $_GET['battle']; 
$golds = $_GET['golds']; 
 
 
 
$result=updateSql("UPDATE `pk_battle_teams` SET  `total_gold`= total_gold+$golds WHERE 
`pk_battle_teams`.`battle`='$battle' AND `pk_battle_teams`.`team_number`='$team' "); 
$team=readRowFromSql("SELECT `id`  FROM `pk_battle_teams` WHERE
 `pk_battle_teams`.`team_number`='$team_number' AND `pk_battle_teams`.`battle`='$battle'",true)['id'];
$result=updateSql("UPDATE `pk_players` SET  `golds`=golds+$golds WHERE `pk_players`.`battle`='$battle',`pk_players`.`index`='$index',`pk_players`.`user`='$player'");  

?>
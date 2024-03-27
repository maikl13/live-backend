<?php



function endDoneAndUpdateTimers(){
	
    endDone();

	 updateTimers();
	//updateSql("	INSERT INTO `log` (`id`, `text`, `created_at`) VALUES 	(NULL, 'endDoneAndUpdateTimers', CURDATE());	");
}

function updateTimers(){
	global $pusher;
    $un_done_battles= readRowFromSql("SELECT 
    `pk_battles`.`id`,
    (`pk_battles`.`period_in_min` * 60) - TIMESTAMPDIFF(SECOND, `pk_battles`.`started_at`, CURRENT_TIMESTAMP()) AS remaining_seconds
FROM 
    `pk_battles`
    	WHERE `pk_battles`.`ended_at` IS NULL
	 ", false);
	
	foreach($un_done_battles as $un_done_battle){
		$battle=$un_done_battle['id'];
		$remaining_seconds=$un_done_battle['remaining_seconds']; 
		$battle_string = (string)$battle;
	$pusher->trigger($battle_string, 'update_timer',  $remaining_seconds);
	 
	}
}
function endDone(){
 global $pusher;
 
 $done_battles= readRowFromSql("
 SELECT 
 `pk_battles`.`id` 
FROM 
 `pk_battles`
WHERE 
(`pk_battles`.`period_in_min` * 60) - TIMESTAMPDIFF(SECOND, `pk_battles`.`started_at`, NOW()) <1
 AND
  `pk_battles`.`ended_at` IS NULL", false);

foreach($done_battles as $done_battle){
	$battle=$done_battle['id'];
 $winner_team= readRowFromSql("SELECT  `pk_battle_teams`.`id` FROM `pk_battle_teams` 
WHERE `pk_battle_teams`.`battle`='$battle'  ORDER BY `pk_battle_teams`.`total_gold` LIMIT 1 ", true)['id'];

$sql = "UPDATE `pk_battles` SET " . ($winner_team != NULL ? "`ended_at` = NOW(), `ended_by_admin` = 0, `winner_team` = $winner_team" : "`ended_at` = NOW(), `ended_by_admin` = 0") . " WHERE `pk_battles`.`id` = '$battle'";
echo $sql;
$result = updateSql($sql);
$battle_string = (string)$battle;
$pusher->trigger($battle_string, 'battle_ended',  $winner_team);
 
 
}
}

?>
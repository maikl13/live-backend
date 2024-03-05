<?php
include "config.php";

 
$places_count = $_GET['places_count']; 
$room = $_GET['room']; 
$admin_team_number = $_GET['admin_team_number']; 
$admin_uid = $_GET['admin_uid']; 
$period_in_min = $_GET['period_in_min']; 
$battle = InsertAndGetId("INSERT INTO `pk_battles` 
(`id`, `room`, `initiated_at`, `started_at`, `ended_at`, `ended_by_admin`, `period_in_min`, `winner_team`, `remaining_seconds`, `admin_team_number`) VALUES 
(NULL, '$room', CURRENT_TIMESTAMP, NULL, NULL, '0', '$period_in_min', NULL, '0', $admin_team_number);");

 
 
for ($x = 1; $x <= $places_count; $x++) {
$result=updateSql("INSERT INTO `pk_mic_places` 
(`id`, `room`, `battle`, `locked`, `place_index`, `user`) VALUES 
(NULL, '$room', '$battle', '0', '$x', NULL);");  


}

 
$result=updateSql("INSERT INTO `pk_battle_teams` 
(`id`, `total_gold`, `battle`, `team_number`)
 VALUES (NULL, '0', '$battle', '1');");  
 $result=updateSql("INSERT INTO `pk_battle_teams` 
 (`id`, `total_gold`, `battle`, `team_number`)
  VALUES (NULL, '0', '$battle', '2');");  
  
 echo $battle;
 
?>
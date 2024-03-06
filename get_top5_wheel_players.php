<?php
include "config.php";
 
$wheel_game_items=readRowFromSql("SELECT  `wheel_game_items`.* FROM `wheel_rounds` 
INNER JOIN `wheel_game_items` ON `wheel_game_items`.`id` =`wheel_rounds`.`winner_item`

WHERE `wheel_rounds`.`done` =0
 ORDER BY `wheel_rounds`.`starts_at`  LIMIT 10
",false);
echo json_encode($wheel_game_items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 
?>
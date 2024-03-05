<?php
include "config.php";



 
 
 $current_round=getCurrentRound();
if($current_round==NULL){
	$randomNumber = rand(1, 8);
 updateSql("INSERT INTO `wheel_rounds` (`id`, `winner_item`, `starts_at`, `ends_at`, `done`)
  VALUES (NULL, $randomNumber, CURDATE() + INTERVAL 5 SECOND, CURDATE() + INTERVAL 35 SECOND, '0');");  
 
 $current_round=getCurrentRound();
}
 
echo json_encode($current_round, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

 
function getCurrentRound(){
 $current_round=readRowFromSql("SELECT  `wheel_rounds`.`id` ,`wheel_rounds`.`starts_at` ,
 `wheel_rounds`.`ends_at`,`wheel_rounds`.`winner_item` FROM `wheel_rounds`    
WHERE `ends_at` > CURDATE()",true);
$wheel_items=readRowFromSql("SELECT 
`wheel_game_items`.`id`,
`wheel_game_items`.`value`,
COALESCE(SUM(`wheel_rounds_bidders`.`value`), 0) AS pot
FROM 
`wheel_game_items` 
LEFT OUTER JOIN 
`wheel_rounds_bidders` ON `wheel_game_items`.`id` = `wheel_rounds_bidders`.`item`
AND `wheel_rounds_bidders`.`round` = '$round'
GROUP BY
`wheel_game_items`.`id`,
`wheel_game_items`.`value`
ORDER BY `wheel_game_items`.`id` ;",false);
$current_round['wheel_items']=$wheel_items;
return $current_round;
}
?>
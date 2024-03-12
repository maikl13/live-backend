<?php
include "config.php";



 
 
$round=readRowFromSql("SELECT  `wheel_rounds`.`id`   FROM `wheel_rounds`    
WHERE ADDTIME(`wheel_rounds`.`starts_at`, '00:00:40') > NOW() ORDER BY id DESC LIMIT 1",true)['id'];
 

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
 
 
echo json_encode($wheel_items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
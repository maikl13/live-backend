<?php
include "config.php";
 
$wheel_rounds_bidders=readRowFromSql("SELECT
SUM(`wheel_rounds_bidders`.`value`* `wheel_rounds_bidders`.`multiplier`) AS won_value,
    `users`.`uid`,
`users`.`full_name`,
`users`.`profile_pic`
FROM
`wheel_rounds_bidders`
INNER JOIN `wheel_rounds` ON  `wheel_rounds`.`winner_item`=`wheel_rounds_bidders`.`item`
AND  `wheel_rounds`.`id` = `wheel_rounds_bidders`.`round`
INNER JOIN `users` ON `users`.`uid` = `wheel_rounds_bidders`.`bidder`
GROUP BY
`users`.`uid` 
ORDER BY
SUM(`wheel_rounds_bidders`.`value`* `wheel_rounds_bidders`.`multiplier`) DESC
LIMIT 5;
",false);
echo json_encode($wheel_rounds_bidders, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
 
?>
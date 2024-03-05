<?php
include "config.php";


 

$result = readRowFromSql("SELECT 
`chat_box`.`id`,
`chat_box`.`size_1`,
`chat_box`.`size_2`,
`chat_box`.`padding_top`,
`chat_box`.`padding_bottom`,
`chat_box`.`padding_start`,
`chat_box`.`padding_end`
FROM `chat_box`  
 ", false) ;
 
 
 
 
 
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
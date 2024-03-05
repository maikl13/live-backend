<?php
include "config.php";

//check custom
 updateSql("UPDATE `custom_themes` SET  `custom_themes`.`available`=0 
 WHERE  CURDATE() >= date_add(`custom_themes`.`created_at` ,interval 7 day)");

//check bought (when not permanent)
 updateSql("UPDATE `users_bought_themes`
INNER JOIN themes ON themes.id=users_bought_themes.theme
SET `users_bought_themes`.`available`=0
WHERE themes.days IS NOT NULL
AND
CURDATE() >= date_add(`users_bought_themes`.`purchase_date` ,interval 7 day)");


 
//check sent (when not permanent)
 updateSql("UPDATE gifted_themes
INNER JOIN themes ON themes.id=gifted_themes.theme
SET `gifted_themes`.`available`=0
WHERE themes.days IS NOT NULL
AND
CURDATE() >= date_add(`gifted_themes`.`date` ,interval 7 day)");
 

//resst
 updateSql("UPDATE rooms
INNER JOIN  users_bought_themes ON users_bought_themes.user_uid=rooms.creator_uid
AND users_bought_themes.theme = rooms.theme AND rooms.theme_type='STORE'
SET rooms.theme = 0, rooms.theme_type = 'STORE'
WHERE
users_bought_themes.available = 0
            AND NOT EXISTS (
                SELECT 1 
                FROM users_bought_themes  table2
                WHERE table2.theme=users_bought_themes.theme
                AND table2.user_uid=rooms.creator_uid
                AND available = 1
 )");
 
 updateSql("UPDATE rooms
INNER JOIN  gifted_themes ON gifted_themes.receiver=rooms.creator_uid
AND gifted_themes.theme = rooms.theme AND rooms.theme_type='STORE'
SET rooms.theme = 0, rooms.theme_type = 'STORE'
WHERE
gifted_themes.available = 0
            AND NOT EXISTS (
                SELECT 1 
                FROM gifted_themes  table2
                WHERE table2.theme=gifted_themes.theme
                AND table2.receiver=rooms.creator_uid
                AND available = 1
 )");

updateSql("UPDATE rooms
INNER JOIN  custom_themes ON custom_themes.creator_uid=rooms.creator_uid
AND custom_themes.id = rooms.theme AND rooms.theme_type='CUSTOM'
SET rooms.theme = 0, rooms.theme_type = 'STORE'
WHERE
custom_themes.available = 0");   
 
?>
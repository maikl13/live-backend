<?php
include "config.php";

 updateSql("UPDATE `roomLevelTasksProgress` SET `todayExp`=0");
 updateSql("UPDATE `userInRoomLevelTasksProgress` SET  `todayPoints` = 0");
 $users_daily_exp_to_spend_in_rooms= readRowFromSql("
  SELECT `constants`.`value` FROM `constants` WHERE
  `constants`.`constant_key`='users_daily_exp_to_spend_in_rooms'",true
    )['value'];
 updateSql(" UPDATE `users_todayExpToSpendInRooms` SET  `todayExpToSpendInRooms`  = '$users_daily_exp_to_spend_in_rooms'");

?>
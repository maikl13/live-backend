<?php
//include "config.php";
include "check_expired_room_locks.php";
include "daily_checker_room_theme.php";
include "reset_daily_level_tasks_progress.php";
include "reset_main_level_exp_daily.php";
include "update_user_premium_subscription_status.php";
include "vip_points_daily_checker.php";
 


 
/*
include "pusher_wheel_timer.php";
set_time_limit(86400);
for ($i = 0; $i < 86399; ++$i) {
   checkWheelTimer();
    sleep(1);
}
*/

?>
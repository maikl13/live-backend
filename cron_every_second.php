<?php
include "config.php";
include "pay.php";
 include "pusher_config.php";
 include "end_pk_cron.php";
 include "pusher_wheel_timer.php";
 include  'cron_update_auctions_timers.php';
 /*
set_time_limit(60);
for ($i = 0; $i < 59; ++$i) {
    checkWheelTimer();
    endDoneAndUpdateTimers();
   sleep(1);
}
*/
$start = microtime(true);
set_time_limit(60);
for ($i = 0; $i < 59; ++$i) {
    checkWheelTimer();
    endDoneAndUpdateTimers();
    updateAuctionsTimers();
    time_sleep_until($start + $i + 1);
}
 
?>
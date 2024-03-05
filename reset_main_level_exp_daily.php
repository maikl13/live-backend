<?php
include "config.php";

 
//  reset all 
$update_level_tasks_progress = updateSql("UPDATE `level_tasks_progress` SET `exp`= '0'");

?>
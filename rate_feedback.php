
<?php
include "config.php";

$user = $_GET['user'];
$rate = $_GET['rate'];
$feedback = $_GET['feedback'];
 

$result = updateSql("UPDATE `feedback` SET `reply_rate` = '$rate' WHERE `feedback`.`id` = $feedback;", true);


 

echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>




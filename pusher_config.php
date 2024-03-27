<?php
require __DIR__ . '/vendor/autoload.php';
$app_id = '1768878';
$app_key = '2c6f687f7d54a2e4b6fa';
$app_secret = '2c858a4b20f1c8586f53';
$app_cluster = 'eu';

$pusher = new Pusher\Pusher($app_key, $app_secret, $app_id, 
['cluster' => $app_cluster]);
?>
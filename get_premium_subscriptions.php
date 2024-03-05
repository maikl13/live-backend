<?php
include "config.php";

$user = $_GET['user'];

$premium_subscriptions = readRowFromSql("SELECT premium_subscription.*,
       DATEDIFF(NOW(), latest_history.date) < 10 AS canRenew
FROM premium_subscription
LEFT JOIN (
    SELECT subscription, MAX(date) AS latest_date
    FROM premium_history
    WHERE user = '$user'
    GROUP BY subscription
) AS latest ON premium_subscription.id = latest.subscription
LEFT JOIN premium_history AS latest_history ON latest.subscription = latest_history.subscription
 AND latest.latest_date = latest_history.date
 ORDER BY premium_subscription.id
", false);

   


echo json_encode($premium_subscriptions, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
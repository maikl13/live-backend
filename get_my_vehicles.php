<?php
include "config.php";
include "pay.php";

$uid =$_GET['uid'];
 
 
    $vehicles= readRowFromSql("SELECT `vehicles`.*,`users_vehicles`.`purchase_date`,SUM(`vehicles`.`days`)- SUM(TIMESTAMPDIFF(DAY, `users_vehicles`.`purchase_date`,CURDATE()))
    as days_left , 
        CASE
    WHEN `users_vehicles`.`vehicle`=`users`.`vehicle`
    THEN 1
    ELSE 0
END as selected
    FROM `users_vehicles` INNER JOIN`vehicles` ON `vehicles`.`id`=`users_vehicles`.`vehicle`
    LEFT OUTER JOIN `users` ON `users`.`uid`=`users_vehicles`.`user`
    WHERE `users_vehicles`.`user`='$uid'
 AND CURDATE()< DATE_ADD(`users_vehicles`.`purchase_date`, INTERVAL 30 DAY) 
        GROUP BY users_vehicles.vehicle", false);

 $result=array();
foreach($vehicles as $vehicle){
    if($vehicle['days_left']>0){
        $vehicle2=$vehicle;
    unset($vehicle2['purchase_date']);
    unset($vehicle2['days_left']);
    unset($vehicle2['selected']);
    $item['vehicle']=$vehicle2;
    $item['days_left']=$vehicle['days_left'];
     $item['selected']=$vehicle['selected'];
    $result[]=$item;
    }
}
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
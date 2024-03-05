<?php
include "config.php";


 
$battle= readRowFromSql("SELECT `pk_battles`.`id` FROM `pk_battles` WHERE `pk_battles`.`room`='$room' AND `pk_battles`.`ended_at`> CURDATE()
AND `pk_battles`.`ended_by_admin`=0
", true)['id'];

 if($battle!=NULL){
	 
 }

?>
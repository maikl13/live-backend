<?php
include "config.php";
 
$lock =$_GET['lock'];
$place_index =$_GET['place_index'];
$battle =$_GET['battle'];

$result =updateSql(" UPDATE pk_mic_places SET locked='$lock' WHERE place_index = '$place_index'  AND pk_mic_places.battle = '$battle' ");
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

?>
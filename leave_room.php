<?php
 
include "leave_room_now.php";

$user_uid = $_GET['user_uid'];
$room_id = $_GET['room_id'];

leaveRoomNow($user_uid,$room_id);




?>
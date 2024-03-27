<?php
session_start();
include('../config/dbcon.php');
include('../authentication.php');



if(isset($_POST['updateroomtypeupgrade']))
{
    $user_id = $_POST['user_id'];
    $cost = $_POST['cost'];
    $room_capacity = $_POST['room_capacity'];
    $room_admin = $_POST['room_admin'];
    $room_member = $_POST['room_member'];

    $query = "UPDATE room_upgrade_types SET room_capacity='$room_capacity',room_admin='$room_admin',room_member='$room_member',cost='$cost' WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Done";
        header("Location: ../roomsupgradetype.php");
    }
    else
    {
        $_SESSION['status'] = " Failed";
        header("Location: ../roomsupgradetype.php");

    }

}


?>
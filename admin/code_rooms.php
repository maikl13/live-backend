<?php
session_start();
include('config/dbcon.php');

//Update Room
if(isset($_POST['updateRoom']))
{
    $room_id = $_POST['room_id'];
    $short_digital_id = $_POST['short_digital_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $room_level = $_POST['room_level'];
    $membership_fee = $_POST['membership_fee'];
    $allow_guests_to_enter = $_POST['allow_guests_to_enter'] == true ? '1':'0';
    $mic_for_members_only = $_POST['mic_for_members_only'] == true ? '1':'0';
    $allow_admins_to_lock_or_unlock_the_mic = $_POST['allow_admins_to_lock_or_unlock_the_mic'] == true ? '1':'0';
    $allow_admins_to_manage_events = $_POST['allow_admins_to_manage_events'] == true ? '1':'0';

    $query = "UPDATE rooms SET short_digital_id='$short_digital_id', title='$title', description='$description', room_level='$room_level',membership_fee='$membership_fee',allow_guests_to_enter='$allow_guests_to_enter',mic_for_members_only='$mic_for_members_only',allow_admins_to_lock_or_unlock_the_mic='$allow_admins_to_lock_or_unlock_the_mic',allow_admins_to_manage_events='$allow_admins_to_manage_events'  WHERE id='$room_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Rooms Edited";
        header("Location: ../rooms.php");
    }
    else
    {
        $_SESSION['status'] = "Rooms EDIT Failed";
        header("Location: ../rooms.php");

    }

}

?>
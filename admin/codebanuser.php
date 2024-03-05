<?php
session_start();
include('config/dbcon.php');
include('authentication.php');


if(isset($_POST['banuser']))
{
    $room_id=$_POST['room'];
    $user_uid=$_POST['user'];


    $query = "INSERT INTO `rooms_forbidden_users` (`id`, `room`, `user`) VALUES (NULL, '$room_id', '$user_uid')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
    $_SESSION['status'] = 'Success';
    $_SESSION['status_code'] = 'success';
    header("Location: gifts.php");
}
else
{
    $_SESSION['status'] = 'ERROR';
    $_SESSION['status_code'] = 'error';
    header("Location: gifts.php");

}
}


?>
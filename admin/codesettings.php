<?php
session_start();
include('config/dbcon.php');
include('authentication.php');

if(isset($_POST['editsettings']))
{
    $user_id = $_POST['user_id'];
    $sitename = $_POST['sitename'];
    $copyright = $_POST['copyright'];
    $version = $_POST['version'];

    $query = "UPDATE websetting SET sitename='$sitename', copyright='$copyright', version='$version' WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Settings Edit Successfully";
        header("Location: ../settings.php");
    }
    else
    {
        $_SESSION['status'] = "Settings Edit Failed";
        header("Location: ../settings.php");

    }

}
?>
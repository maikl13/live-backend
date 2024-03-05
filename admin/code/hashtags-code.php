<?php
session_start();
include('../config/dbcon.php');
include('../authentication.php');



if(isset($_POST['updatehashtags']))
{
    $user_id = $_POST['user_id'];
    $title = $_POST['title'];

    $query = "UPDATE hashtags SET title='$title' WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Done";
        header("Location: ../hashtags.php");
    }
    else
    {
        $_SESSION['status'] = " Failed";
        header("Location: ../hashtags.php");

    }

}


?>
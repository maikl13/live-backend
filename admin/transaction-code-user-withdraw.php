<?php
session_start();
include('config/dbcon.php');
include('authentication.php');

if(isset($_POST['updatetofailed']))
{
    $transaction_id = $_POST['transaction_id'];
    $status = $_POST['status'];

    $query = "UPDATE withdraw_request SET status='failed' WHERE id='$transaction_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Withdraw Change Status Successfully";
        header("Location: withdraw-users-allrequest.php");
    }
    else
    {
        $_SESSION['status'] = "Withdraw Change Status Failed";
        header("Location: withdraw-users-allrequest.php");

    }

}
?>
<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['editagencycommission']))
{
    $value = $_POST['value'];

    $query = "UPDATE constants SET `value`='$value' WHERE `constant_key`='agency_profit_percentage'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = 'success';
        $_SESSION['status_code'] = 'success';
        header("Location: agency-commission.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header("Location: agency-commission.php");

    }

}
?>
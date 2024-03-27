<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['editsystemcommission']))
{
    $value = $_POST['value'];

    $query = "UPDATE constants SET `value`='$value' WHERE `constant_key`='app_owner_profit_percentage_from_golds_gifts'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = 'success';
        $_SESSION['status_code'] = 'success';
        header("Location: system-commission.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header("Location: system-commission.php");

    }

}
?>
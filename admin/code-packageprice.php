<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['updatePackage']))
{
    $package_id = $_POST['package_id'];
    $value_in_coins = $_POST['value_in_coins'];
    $value_in_real_money = $_POST['value_in_real_money'];
    $payment_id = $_POST['payment_id'];

    $query = "UPDATE coins_packages SET value_in_coins='$value_in_coins', value_in_real_money='$value_in_real_money', payment_id='$payment_id' WHERE id='$package_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = 'success';
        $_SESSION['status_code'] = 'success';
        header("Location: package-price.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header("Location: package-price.php");

    }

}
?>
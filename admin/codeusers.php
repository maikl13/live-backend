<?php
session_start();
include('config/dbcon.php');

//Update Users
if(isset($_POST['updateUser']))
{
    $user_id = $_POST['user_id'];
    $short_digital_id = $_POST['short_digital_id'];
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $gold = $_POST['gold'];
    $crystals = $_POST['crystals'];
    $current_vip_subscription = $_POST['current_vip_subscription'];
    $bio = $_POST['bio'];
    $account_status = $_POST['account_status'];

    $query = "UPDATE users SET short_digital_id='$short_digital_id', current_vip_subscription='$current_vip_subscription', full_name='$full_name', bio='$bio', gender='$gender', gold='$gold', account_status='$account_status', crystals='$crystals' WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "User Edited";
        header("Location: users.php");
    }
    else
    {
        $_SESSION['status'] = "Users EDIT Failed";
        header("Location: users.php");

    }

}

//delete user
if(isset($_POST['DeleteAdminbtn']))
{
    $user_id = $_POST['delete_id'];

    $query = "DELETE FROM users WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "User Delete Done";
    header("Location: ../users.php");
}
else
{
    $_SESSION['status'] = "User Delete Failed";
    header("Location: ../users.php");

}
}


?>
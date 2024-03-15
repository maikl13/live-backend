<?php
session_start();
include('config/dbcon.php');
include('authentication.php');



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatetofailed'])) {
    $transaction_id = $_POST['transaction_id'];
    $status = $_POST['status'];

    $query = "UPDATE withdraw_request SET status='failed' WHERE id='$transaction_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        // Fetch amount from withdraw_request table
        $fetch_query = "SELECT amount FROM withdraw_request WHERE id='$transaction_id'";
        $fetch_result = mysqli_query($con, $fetch_query);
        $row = mysqli_fetch_assoc($fetch_result);
        $amount = $row['amount'];

        // Fetch user_id from withdraw_request table
        $fetch_user_query = "SELECT uid FROM withdraw_request WHERE id='$transaction_id'";
        $fetch_user_result = mysqli_query($con, $fetch_user_query);
        $row_user = mysqli_fetch_assoc($fetch_user_result);
        $uid = $row_user['uid'];

        // Add the amount back to user's gold balance
        $update_query = "UPDATE users SET gold = gold + $amount WHERE uid='$uid'";
        $update_result = mysqli_query($con, $update_query);

        if($update_result) {
            $_SESSION['status'] = "Withdraw Change Status Successfully";
            $_SESSION['status_code'] = 'success';
            header("Location: withdraw-users-allrequest.php");
        } else {
            $_SESSION['status'] = "Failed to add amount back to user's balance";
            $_SESSION['status_code'] = 'error';
            header("Location: withdraw-users-allrequest.php");
        }
    } else {
        $_SESSION['status'] = "Withdraw Change Status Failed";
        $_SESSION['status_code'] = 'error';
        header("Location: withdraw-users-allrequest.php");
    }
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatetopending']))
 {

    $transaction_id = $_POST['transaction_id'];
    $status = $_POST['status'];

    $query = "UPDATE withdraw_request SET status='pending' WHERE id='$transaction_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Withdraw Change Status Successfully";
        $_SESSION['status_code'] = 'success';
        header("Location: withdraw-users-allrequest.php");
    }
    else
    {
        $_SESSION['status'] = "Withdraw Change Status Failed";
        $_SESSION['status_code'] = 'error';
        header("Location: withdraw-users-allrequest.php");

    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatetoprocessing']))
 {

    $transaction_id = $_POST['transaction_id'];
    $status = $_POST['status'];

    $query = "UPDATE withdraw_request SET status='processing' WHERE id='$transaction_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Withdraw Change Status Successfully";
        $_SESSION['status_code'] = 'success';
        header("Location: withdraw-users-allrequest.php");
    }
    else
    {
        $_SESSION['status'] = "Withdraw Change Status Failed";
        $_SESSION['status_code'] = 'error';
        header("Location: withdraw-users-allrequest.php");

    }

}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatetocompleted'])) {
    $transaction_id = $_POST['transaction_id'];
    $status = $_POST['status'];

        // Assume you have stored admin ID in session when logged in
        $action_by = $_SESSION['auth_user']['user_name'];

    $query = "UPDATE withdraw_request SET status='completed', datelastaction=NOW() WHERE id='$transaction_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        // Fetch user_id, amount, and datelastaction from withdraw_request table
        $fetch_query = "SELECT uid, amount, datelastaction FROM withdraw_request WHERE id='$transaction_id'";
        $fetch_result = mysqli_query($con, $fetch_query);
        $row = mysqli_fetch_assoc($fetch_result);
        $uid = $row['uid'];
        $amount = $row['amount'];
        $datelastaction = $row['datelastaction'];

        // Insert a record into withdraw_request_user_logs
        $insert_query = "INSERT INTO withdraw_request_user_logs (order_id, uid, amount, status, datelastaction, action_by) 
                         VALUES ('$transaction_id', '$uid', '$amount', 'completed', '$datelastaction', '$action_by')";
        $insert_result = mysqli_query($con, $insert_query);

        if ($insert_result) {
            $_SESSION['status'] = "Withdraw Change Status Successfully";
            $_SESSION['status_code'] = 'success';
        } else {
            $_SESSION['status'] = "Failed to insert log entry.";
            $_SESSION['status_code'] = 'error';
        }
        header("Location: withdraw-users-allrequest.php");
    } else {
        $_SESSION['status'] = "Withdraw Change Status Failed";
        $_SESSION['status_code'] = 'error';
        header("Location: withdraw-users-allrequest.php");
    }
}


?>
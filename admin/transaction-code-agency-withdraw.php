<?php
session_start();
include('config/dbcon.php');
include('authentication.php');



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatetofailed'])) {
    $transaction_id = $_POST['transaction_id'];
    $status = $_POST['status'];

    $query = "UPDATE withdraw_request_agency SET status='failed' WHERE id='$transaction_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        // Fetch amount and agency_id from withdraw_request_agency table
        $fetch_query = "SELECT amount, agencyid FROM withdraw_request_agency WHERE id='$transaction_id'";
        $fetch_result = mysqli_query($con, $fetch_query);
        $row = mysqli_fetch_assoc($fetch_result);
        $amount = $row['amount'];
        $agency_id = $row['agencyid'];

        // Deduct the amount from agency balance
        $update_query = "UPDATE agency SET balance = balance + $amount WHERE id='$agency_id'";
        $update_result = mysqli_query($con, $update_query);

        if($update_result) {
            $_SESSION['status'] = "Withdraw Change Status Successfully";
            $_SESSION['status_code'] = 'success';
            header("Location: withdraw-agency-allrequest.php");
        } else {
            $_SESSION['status'] = "Failed to deduct amount from agency balance";
            $_SESSION['status_code'] = 'error';
            header("Location: withdraw-agency-allrequest.php");
        }
    } else {
        $_SESSION['status'] = "Withdraw Change Status Failed";
        $_SESSION['status_code'] = 'error';
        header("Location: withdraw-agency-allrequest.php");
    }
}




if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatetopending']))
 {

    $transaction_id = $_POST['transaction_id'];
    $status = $_POST['status'];

    $query = "UPDATE withdraw_request_agency SET status='pending' WHERE id='$transaction_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Withdraw Change Status Successfully";
        $_SESSION['status_code'] = 'success';
        header("Location: withdraw-agency-allrequest.php");
    }
    else
    {
        $_SESSION['status'] = "Withdraw Change Status Failed";
        $_SESSION['status_code'] = 'error';
        header("Location: withdraw-agency-allrequest.php");

    }

}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatetoprocessing']))
 {

    $transaction_id = $_POST['transaction_id'];
    $status = $_POST['status'];

    $query = "UPDATE withdraw_request_agency SET status='processing' WHERE id='$transaction_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Withdraw Change Status Successfully";
        $_SESSION['status_code'] = 'success';
        header("Location: withdraw-agency-allrequest.php");
    }
    else
    {
        $_SESSION['status'] = "Withdraw Change Status Failed";
        $_SESSION['status_code'] = 'error';
        header("Location: withdraw-agency-allrequest.php");

    }

}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['updatetocompleted'])) {
    $transaction_id = $_POST['transaction_id'];
    $status = $_POST['status'];

        // Assume you have stored admin ID in session when logged in
        $action_by = $_SESSION['auth_user']['user_name'];

    $query = "UPDATE withdraw_request_agency SET status='completed', datelastaction=NOW() WHERE id='$transaction_id'";
    $query_run = mysqli_query($con, $query);

    if($query_run) {
        // Fetch user_id, amount, and datelastaction from withdraw_request table
        $fetch_query = "SELECT agencyid, amount, datelastaction FROM withdraw_request_agency WHERE id='$transaction_id'";
        $fetch_result = mysqli_query($con, $fetch_query);
        $row = mysqli_fetch_assoc($fetch_result);
        $agencyid = $row['agencyid'];
        $amount = $row['amount'];
        $datelastaction = $row['datelastaction'];

        // Insert a record into withdraw_request_user_logs
        $insert_query = "INSERT INTO withdraw_request_agency_logs (order_id, agencyid, amount, status, datelastaction, action_by) 
                         VALUES ('$transaction_id', '$agencyid', '$amount', 'completed', '$datelastaction', '$action_by')";
        $insert_result = mysqli_query($con, $insert_query);

        if ($insert_result) {
            $_SESSION['status'] = "Withdraw Change Status Successfully";
            $_SESSION['status_code'] = 'success';
        } else {
            $_SESSION['status'] = "Failed to insert log entry.";
            $_SESSION['status_code'] = 'error';
        }
        header("Location: withdraw-agency-allrequest.php");
    } else {
        $_SESSION['status'] = "Withdraw Change Status Failed";
        $_SESSION['status_code'] = 'error';
        header("Location: withdraw-agency-allrequest.php");
    }
}


?>
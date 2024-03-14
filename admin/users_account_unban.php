<?php
session_start();
include('config/dbcon.php');

	// Check if id is set or not if true toggle,
	// else simply go back to the page
	if (isset($_GET['id'])){

		// Store the value from get to a
		// local variable "course_id"
		$user_id=$_GET['id'];

		// SQL query that sets the status
		// to 1 to indicate activation.
		$query="UPDATE users SET account_status = NULL WHERE id = '$user_id'";
        $query_run = mysqli_query($con, $query);
	}

    if($query_run)
    {
        $_SESSION['status'] = 'User has been successfully Unbanned';
        $_SESSION['status_code'] = 'success';
        header("Location: users.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header("Location: users.php");

    }

?>
<?php
include('config/dbcon.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if it's a POST request and leave parameter is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['leave'])) {
    // Check if the custom header is set in the request
    $customHeaderName = 'UID';

    // Check if the UID is set in the POST data
    if(isset($_POST['uid'])){
        $userId = $_POST['uid'];

        // Sanitize the user ID to prevent SQL injection
        $userId = $conn->real_escape_string($userId);

        // Query to check the user's agency
        $sql = "SELECT * FROM users WHERE uid = '$userId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User found
            $row = $result->fetch_assoc();
            $agency_id = $row["agency_id"];
            $user_uid = $row["uid"]; // Add this line to get user_uid

            // Query to get the leave cost from the agency
            $sql = "SELECT leave_cost FROM agency WHERE id = '$agency_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Found the leave cost
                $row = $result->fetch_assoc();
                $leave_cost = $row["leave_cost"];

                // Check if the user has enough gold
                $sql = "SELECT gold FROM users WHERE uid = '$userId'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Found the gold
                    $row = $result->fetch_assoc();
                    $user_gold = $row["gold"];

                    if ($user_gold >= $leave_cost) {
                        // User has enough gold for leaving
                        // Deduct gold from user's wallet
                        $new_user_gold = $user_gold - $leave_cost;
                        $sql = "UPDATE users SET gold = $new_user_gold WHERE uid = '$userId'";
                        $conn->query($sql);

                        // Add gold to agency's wallet
                        $sql = "UPDATE agency SET balance = balance + $leave_cost WHERE id = '$agency_id'";
                        $conn->query($sql);

                        // Update the user's agency_id to NULL
                        $sql = "UPDATE users SET agency_id = NULL WHERE uid = '$userId'";
                        $conn->query($sql);

                        // Insert notification into agency_notifications
                        $message = "Leave This Agency And Paid: $leave_cost Gold"; // Include leave cost in the message
                        $sql = "INSERT INTO agency_notifications (user_uid, agency_id, message, read_status, datetime) 
                                                      VALUES ('$user_uid', '$agency_id', '$message', 0, NOW())";
                        $conn->query($sql);

                        // Redirect to another page after successful leave process
                        header("Location: success_leave.php");
                        exit(); // Terminate script after redirect
                    } else {
                        // Insufficient gold
                        header("Location: success_leave.php");
                        exit(); // Terminate script after redirect
                    }
                } else {
                    // Gold not found
                    echo "An error occurred while checking for gold.";
                }
            } else {
                // Leave cost not found
                echo "An error occurred while finding the leave cost.";
            }
        } else {
            // User does not have an agency
            echo "Sorry, you don't have an agency.";
        }
    } else {
        // If the UID is not set in the POST data
        echo "Please pass the user ID through the form.";
    }
}

// Close database connection
$conn->close();
?>

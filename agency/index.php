<?php

include('config/dbcon.php');

// Replace 'Your-Header-Name' with the actual name of your custom header
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Query to retrieve user data based on the user ID
    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT * FROM users WHERE uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Check if the agency_id field is NULL
        if ($userData['agency_id'] === NULL) {
            // Redirect to a page if the agency_id field is NULL (replace 'null_page.php' with the actual page)
            header("Location: search.php");
            exit();
        } else {
            // Redirect to another page if the agency_id field is not NULL (replace 'other_page.php' with the actual page)
            header("Location: host-center.php");
            exit();
        }
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

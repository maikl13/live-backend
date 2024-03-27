<?php
// Include database connection file
include('config/dbcon.php');

// Get the user ID from the submitted form
$userId = $_POST['userId'];

// Retrieve the updated leave cost from the form
$updatedLeaveCost = $_POST['leave_cost'];

// Prepare SQL query to update the leave cost in the database
$updateQuery = "UPDATE agency SET leave_cost = '$updatedLeaveCost' WHERE owner_uid = '$userId'";

// Execute the update query
$updateResult = mysqli_query($conn, $updateQuery);

// Check if update was successful
if ($updateResult) {
    // Redirect to success-page.php
    header("Location: success-settings.php");
    exit(); // Stop further execution
} else {
    echo "Error updating leave cost: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>

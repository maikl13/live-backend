<?php
session_start();
include('includes/header.php');
include('config/dbcon.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve agency_id and user_uid from POST request
  $agency_id = $_POST['agency_id'];
  $userId = $_POST['user_uid'];

  // Database configuration
  // Prepare and bind the SQL statement for checking if the user_uid has already submitted a request
  $stmt_check_existing_user_request = $conn->prepare("SELECT * FROM agency_join_request WHERE user_uid = ?");
  
  // Set parameter and execute the SQL statement for checking
  $stmt_check_existing_user_request->bind_param("s", $userId);
  $stmt_check_existing_user_request->execute();
  
  // Store the result
  $result = $stmt_check_existing_user_request->get_result();
  
  // If a row exists, it means the user_uid has already submitted a request, so don't proceed
  if ($result->num_rows > 0) {
      $stmt_check_existing_user_request->close();
      $conn->close();
      header("Location: pending.php"); // Redirect to pending page
      exit; // Terminate the script
  } else {
      // Prepare and bind the SQL statement for inserting agency join request
      $stmt_agency_join_request = $conn->prepare("INSERT INTO agency_join_request (agency_id, user_uid) VALUES (?, ?)");
      
      // Set parameters and execute for inserting agency join request
      $stmt_agency_join_request->bind_param("ss", $agency_id, $userId);
      $stmt_agency_join_request->execute();
      
      // Close the prepared statement for inserting
      $stmt_agency_join_request->close();
      
      // Close the prepared statement for checking
      $stmt_check_existing_user_request->close();
      
      // Close the database connection
      $conn->close();
      
      // Redirect to success page
      header("Location: success.php");
      exit; // Terminate the script
  }
}


?>

    <!-- Preloader -->
    <div id="preloader">
      <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>
    <!-- Internet Connection Status -->
    <!-- # This code for showing internet connection status -->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Header Area -->
    <div class="header-area" id="headerArea">
      <div class="container">
        <!-- # Paste your Header Content from here -->
        <!-- # Header Five Layout -->
        <!-- # Copy the code from here ... -->
        <!-- Header Content -->
        <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
          <!-- Logo Wrapper -->
          <div class="logo-wrapper"><a href="page-home.html"><img src="img/core-img/logo.png" alt=""></a></div>
          <!-- Navbar Toggler -->
          <div class="navbar--toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas" data-bs-target="#affanOffcanvas" aria-controls="affanOffcanvas"><span class="d-block"></span><span class="d-block"></span><span class="d-block"></span></div>
        </div>
        <!-- # Header Five Layout End -->
      </div>
    </div>
    <!-- # Sidenav Left -->
    <div class="page-content-wrapper py-3">
      <div class="container">
        <!-- User Information-->
        <div class="card user-info-card mb-3">
          <div class="card-body d-flex align-items-center">
<?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $agency_id = $_GET['id'];

    // Query to retrieve user data based on the user ID
    $sql = "SELECT * FROM agency WHERE id = '$agency_id'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<div class='user-profile me-3'><img src='../images/{$userData['image']}' alt=''><i class='bi bi-pencil'></i></div>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
            <div class="user-info">
              <div class="d-flex align-items-center">
                <h5 class="mb-1">
                <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);


    $agency_id = $_GET['id'];

    // Query to retrieve user data based on the user ID
    $sql = "SELECT * FROM agency WHERE id = '$agency_id'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "{$userData['name']}";
          } else {
        echo "No agency found with the provided ID.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
                </h5><span class="badge bg-warning ms-2 rounded-pill">
                <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $agency_id = $_GET['id'];

    // Query to count the number of users belonging to the agency
    $sql = "SELECT COUNT(*) AS total_users FROM users WHERE agency_id = '$agency_id'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result) {
        // Fetch the result
        $row = $result->fetch_assoc();
        
        // Retrieve the total number of users
        $totalUsers = $row['total_users'];

        // Output the total number of users
        echo "$totalUsers Members";
    } else {
        echo "Error executing query: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
                </span>
              </div>
              <p class="mb-0">
              <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);


    $agency_id = $_GET['id'];

    // Query to retrieve user data based on the user ID
    $sql = "SELECT * FROM agency WHERE id = '$agency_id'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "{$userData['bio']} ";
          } else {
        echo "No agency found with the provided ID.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

              </p>
            </div>
          </div>
        </div>
        <!-- User Meta Data-->
        <div class="card user-data-card">
          <div class="card-body">
          <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="auth-form p-0" target="_blank">
              <div class="form-group mb-3">
              <input type="hidden" name="user_uid" class="form-control" value="<?php echo $userId; ?>">
              <input type="hidden" name="agency_id" class="form-control" value="<?php echo $agency_id; ?>">
              </div>
              <button class="btn btn-success w-100" type="submit">Request Join Agency</button>
            </form>
          </div>
        </div>
      </div>
    </div>


    
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<?php include('includes/script.php'); ?>


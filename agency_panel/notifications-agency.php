<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="mpay" />
  <meta name="keywords" content="mpay" />
  <meta name="author" content="mpay" />
  <link rel="manifest" href="manifest.json" />
  <link rel="icon" href="assets/images/logo/favicon.png" type="image/x-icon" />
  <title>Agency Notifications</title>
  <link rel="apple-touch-icon" href="assets/images/logo/favicon.png" />
  <meta name="theme-color" content="#122636" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black" />
  <meta name="apple-mobile-web-app-title" content="mpay" />
  <meta name="msapplication-TileImage" content="assets/images/logo/favicon.png" />
  <meta name="msapplication-TileColor" content="#FFFFFF" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />

  <!--Google font-->
  <link rel="preconnect" href="https://fonts.googleapis.com/" />
  <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&amp;display=swap" rel="stylesheet" />

  <!-- bootstrap css -->
  <link rel="stylesheet" id="rtl-link" type="text/css" href="assets/css/vendors/bootstrap.min.css" />

  <!-- swiper css -->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/swiper-bundle.min.css" />

  <!-- Theme css -->
  <link rel="stylesheet" id="change-link" type="text/css" href="assets/css/style.css" />
</head>

<body>
  <!-- header start -->
  <header class="section-t-space">
    <div class="custom-container">
      <div class="header-panel">
        <a href="index.php" class="back-btn">
          <i class="icon" data-feather="arrow-left"></i>
        </a>
        <h2>Agency Notifications</h2>

        <div class="dropdown">
          <a href="#" class="back-btn" role="button" data-bs-toggle="dropdown">
            <i class="icon" data-feather="settings"></i>
          </a>

          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Mark as all read</a></li>
          </ul>
        </div>
      </div>
    </div>
  </header>
  <!-- header end -->

  <!-- notification section starts -->


  <section class="section-b-space">
  <?php
require 'config/dbcon.php';

$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve agencyid from agency table based on owner_uid
    $agencyIdQuery = "SELECT id FROM agency WHERE owner_uid = '$userId'";
    $agencyIdResult = $conn->query($agencyIdQuery);

    // Check if the query was successful
    if ($agencyIdResult && $agencyIdResult->num_rows > 0) {
        // Fetch the agencyid
        $agencyRow = $agencyIdResult->fetch_assoc();
        $agencyId = $agencyRow['id'];

        // Query to retrieve user data based on user ID and agencyid
        $sql = "SELECT u.full_name, u.short_digital_id, u.profile_pic, an.agency_id, an.message, an.read_status, an.datetime
        FROM users u
        JOIN agency_notifications an ON CONVERT(u.uid USING utf8mb4) = CONVERT(an.user_uid USING utf8mb4)
        WHERE an.agency_id = '$agencyId' AND an.read_status != 1;";

        // Execute the query
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            // Use user data as needed
            while ($row = $result->fetch_assoc()) {
                // Display the invoice based on retrieved user data
                ?>
    <div class="custom-container">
      <div class="title">
      </div>

      <ul class="notification-list">
        <li class="notification-box">
          <div class="notification-img">
          <img class="img-fluid icon" src="../images/<?php echo $row['profile_pic']; ?>" alt="" />
          </div>
          <div class="notification-details">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <a href="receive-money.html">
                  <h5 class="fw-semibold dark-text"><?php echo $row['full_name']; ?></h5>
                </a>
                <h6 class="fw-normal light-text mt-1">ID : <?php echo $row['short_digital_id']; ?></h6>
              </div>
              <h6 class="time fw-normal light-text"><?php echo $row['datetime']; ?></h6>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-3">
              <h5 class="dark-text fw-normal"><?php echo '<span style="font-weight: bold; color: green;">' . $row['message'] . '</span>'; ?> <span
                  class="fw-semibold theme-color"></span></h5>
            </div>
          </div>
        </li>

      </ul>
    </div>
    <?php
            }
        } else {
            echo "No invoices found for this agency.";
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "No agency found for this user.";
    }
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>

  </section>
  <!-- notification section end -->

  <!-- feather js -->
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/custom-feather.js"></script>

  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- script js -->
  <script src="assets/js/script.js"></script>
</body>

</html>
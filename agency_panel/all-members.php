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
  <title>All Members</title>
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
        <h2>All Members</h2>
      </div>
    </div>
  </header>
  <!-- header end -->

  <!-- search section starts -->
  <section>
    <div class="custom-container">
      <form class="theme-form search-head" target="_blank">
        <div class="form-group">
          <div class="form-input">
            <input type="text" class="form-control search" id="inputusername" placeholder="Search here..." />
            <i class="search-icon" data-feather="search"></i>
          </div>
        </div>
      </form>
    </div>
  </section>
  <!-- search section end -->

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
        $sql = "SELECT u.full_name, u.short_digital_id, u.profile_pic
        FROM users u
        WHERE u.agency_id = '$agencyId'";

        // Execute the query
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            // Use user data as needed
            while ($row = $result->fetch_assoc()) {
                // Display the invoice based on retrieved user data
                ?>
                <!-- person list starts -->
                <section>
                  <div class="custom-container">
                    <ul class="transfer-list">
                      <li class="w-100">
                        <div class="transfer-box">
                          <div class="transfer-img">
                          <img class="img-fluid icon" src="../images/<?php echo $row['profile_pic']; ?>" alt="" />
                          </div>
                          <div class="transfer-details">
                            <div>
                              <a href="#">
                                <h5 class="fw-semibold dark-text"><?php echo $row['full_name']; ?></h5>
                              </a>
                              <h6 class="fw-normal light-text mt-2">ID : <?php echo $row['short_digital_id']; ?></h6>
                            </div>
                            <div class="dropdown">
                              <a href="#" role="button" data-bs-toggle="dropdown">
                                <i class="icon dark-text" data-feather="more-vertical"></i>
                              </a>

                              <ul class="dropdown-menu">
                                <li><a class="dropdown-item w-100" href="person-transaction.html">Set Co-Leader</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </section>
                <!-- person list end -->
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

  <!-- feather js -->
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/custom-feather.js"></script>

  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- script js -->
  <script src="assets/js/script.js"></script>
</body>

</html>
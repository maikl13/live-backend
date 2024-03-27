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
  <title>mPay App</title>
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
        <a class="sidebar-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLeft">
          <i class="menu-icon" data-feather="menu"></i>
        </a>
        <h2>Settings</h2>
      </div>
    </div>
  </header>
  <!-- header end -->

  <!-- profile section start -->
  <section class="section-b-space">
    <div class="custom-container">
      <div class="profile-section">
        <div class="profile-banner">
          <div class="profile-image">
            <img class="img-fluid profile-pic" src="assets/images/person/p3.png" alt="p3" />
          </div>
        </div>
        <h2>
        <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve agency_id based on the user's UID
    $sql = "SELECT owner_uid FROM agency WHERE owner_uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch owner_uid
        $row = $result->fetch_assoc();
        $ownerUid = $row['owner_uid'];

        // Query to retrieve agency_id based on owner_uid
        $sql = "SELECT id FROM agency WHERE owner_uid = '$ownerUid'";
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            // Fetch agency_id
            $row = $result->fetch_assoc();
            $agencyId = $row['id'];

            // Query to calculate total_profit for the agency
            $sql = "SELECT name FROM agency WHERE id = '$agencyId'";

            // Execute the query
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result && $result->num_rows > 0) {
                // Fetch total_profit data
                $name = $result->fetch_assoc();

                // Use total_profit data as needed
                echo "{$name['name']}";
            } else {
                echo "No data found for agency with ID $agencyId.";
            }
        } else {
            echo "No agency found for owner UID $ownerUid.";
        }
    } else {
        echo "User with UID $userId not found in agency table.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
        </h2>
        <h5>
        <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve agency_id based on the user's UID
    $sql = "SELECT owner_uid FROM agency WHERE owner_uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch owner_uid
        $row = $result->fetch_assoc();
        $ownerUid = $row['owner_uid'];

        // Query to retrieve agency_id based on owner_uid
        $sql = "SELECT id FROM agency WHERE owner_uid = '$ownerUid'";
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            // Fetch agency_id
            $row = $result->fetch_assoc();
            $agencyId = $row['id'];

            // Query to calculate total_profit for the agency
            $sql = "SELECT id FROM agency WHERE id = '$agencyId'";

            // Execute the query
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result && $result->num_rows > 0) {
                // Fetch total_profit data
                $id = $result->fetch_assoc();

                // Use total_profit data as needed
                echo "ID : {$id['id']}";
            } else {
                echo "No data found for agency with ID $agencyId.";
            }
        } else {
            echo "No agency found for owner UID $ownerUid.";
        }
    } else {
        echo "User with UID $userId not found in agency table.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
        </h5>
      </div>

      <ul class="profile-list">
        <li>
          <a href="co-founder.php" class="profile-box">
            <div class="profile-img">
              <i class="icon" data-feather="credit-card"></i>
            </div>
            <div class="profile-details">
              <h4>Co-Founder</h4>
              <img class="img-fluid arrow" src="assets/images/svg/arrow.svg" alt="arrow" />
            </div>
          </a>
        </li>
        <li>
        <a href="leave-price.php" class="profile-box">
            <div class="profile-img">
              <i class="icon" data-feather="credit-card"></i>
            </div>
            <div class="profile-details">
              <h4>Leave Price</h4>
              <img class="img-fluid arrow" src="assets/images/svg/arrow.svg" alt="arrow" />
            </div>
          </a>
        </li>
        <li>
        <a href="withdraw.php" class="profile-box">
            <div class="profile-img">
              <i class="icon" data-feather="credit-card"></i>
            </div>
            <div class="profile-details">
              <h4>Withdraw</h4>
              <img class="img-fluid arrow" src="assets/images/svg/arrow.svg" alt="arrow" />
            </div>
          </a>
        </li>
        <li>
      </ul>
    </div>
  </section>
  <!-- profile section end -->

  <!-- panel-space start -->
  <section class="panel-space"></section>
  <!-- panel-space end -->


  <!-- swiper js -->
  <script src="assets/js/swiper-bundle.min.js"></script>
  <script src="assets/js/custom-swiper.js"></script>

  <!-- feather js -->
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/custom-feather.js"></script>

  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- script js -->
  <script src="assets/js/script.js"></script>
</body>

</html>
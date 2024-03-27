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
  <title>Request Members</title>
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
        <h2>Request Members</h2>
      </div>
    </div>
  </header>
  <!-- header end -->

  <!-- Buy & Sell history section starts -->
  <section>
    <div class="custom-container">
      <div class="title">
        <h2 class="light-text fw-normal">Request Members</h2>
        </div>

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
  $sql = "SELECT agency_join_request.*, users.full_name, users.profile_pic, users.short_digital_id
  FROM agency_join_request
  JOIN users ON agency_join_request.user_uid COLLATE utf8mb4_unicode_ci = users.uid COLLATE utf8mb4_unicode_ci
  WHERE agency_join_request.user_uid = '$userId' 
    AND agency_join_request.agency_id = '$agencyId'
    AND agency_join_request.status = 'pending';";

  // Execute the query
  $result = $conn->query($sql);

  // Check if the query was successful
  if ($result && $result->num_rows > 0) {
      // Use user data as needed
      while ($row = $result->fetch_assoc()) {
          // Display the invoice based on retrieved user data
          ?>
    <div class="transaction-box">
            <a href="index.php" class="d-flex gap-3">
              <div class="transaction-image color1">
              <img class="img-fluid icon" src="../images/<?php echo $row['profile_pic']; ?>" alt="user_image" />
              </div>
              <div class="transaction-details">
                <div class="transaction-name">
                <input type="hidden" name="request_id" class="form-control" value="<?php echo $row['request_id']; ?>">
                <h5><?php echo $row['full_name']; ?></h5>
                </div>
                <div class="d-flex justify-content-between">
                  <h5 class="light-text">ID : <?php echo $row['short_digital_id']; ?></h5>
                  <form action="code-accept-member.php" method="post">
                  <button type="submit" value="<?php echo $row['request_id']; ?>" name="request_id" class="btn theme-btn">Accept</button>
                  </form>
                  <form action="code-reject-member.php" method="post">
                  <button type="submit" value="<?php echo $row['request_id']; ?>" name="request_id" class="btn theme-btn">Reject</button>
                  </form>
                  </div>
                        </div>
                    </a>
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
        </div>
        </div>
  </section>
  <!-- Transaction section end -->



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  
  <!-- feather js -->
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/custom-feather.js"></script>

  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- script js -->
  <script src="assets/js/script.js"></script>
</body>

</html>
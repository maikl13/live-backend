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
  <title>Settings</title>
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
        <a href="settings.php" class="back-btn">
          <i class="icon" data-feather="arrow-left"></i>
        </a>
        <h2>Leave Agency Members</h2>
      </div>
    </div>
  </header>
  <!-- header end -->


  <!-- request details section start -->
  <section class="section-b-space">
    <div class="custom-container">
    <?php
// Include database connection file
include('config/dbcon.php');

// Get the UID from the HTTP header
$userId = $_SERVER['HTTP_UID'];

// Prepare SQL query to fetch agency information based on user's UID
$query = "SELECT * FROM agency WHERE owner_uid = '$userId'";

// Execute the query
$result = mysqli_query($conn, $query);

// Check if query was successful
if ($result) {
    // Fetch agency information
    $agency = mysqli_fetch_assoc($result);
    
    // Check if agency exists for the user
    if ($agency) {
        // Store agency name and bio in variables
        $agencyName = $agency['name'];
        $agencyBio = $agency['bio'];
        // Retrieve current leave cost from the agency table
        $currentLeaveCost = $agency['leave_cost'];
        // Retrieve agency ID
        $agencyId = $agency['id'];

        // Fetch all users belonging to the same agency
        $userQuery = "SELECT * FROM users WHERE agency_id = '$agencyId'";
        $userResult = mysqli_query($conn, $userQuery);
        $coFounders = mysqli_fetch_all($userResult, MYSQLI_ASSOC);
    } else {
        // If agency does not exist for the user, set default values
        $agencyName = "Agency Name Not Found";
        $agencyBio = "Agency BIO Not Found";
        // Set default leave cost
        $currentLeaveCost = 0;
        // Set coFounders to an empty array
        $coFounders = [];
    }
} else {
    // If query fails, display error message
    $agencyName = "Error: " . mysqli_error($conn);
    $agencyBio = "Error: " . mysqli_error($conn);
    // Set default leave cost
    $currentLeaveCost = 0;
    // Set coFounders to an empty array
    $coFounders = [];
}

// Close database connection
mysqli_close($conn);
?>
<!-- Fill input fields with PHP variables -->
<div class="form-group">
    <form method="post" action="save-leave-price.php">
        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
        <label for="leave_cost" class="form-label">Price Members Leave agency ( Golds )</label>
        <select id="leave_cost" class="form-select" name="leave_cost">
            <option value="0" <?php if ($currentLeaveCost == 0) echo 'selected'; ?>>0 Golds</option>
            <option value="10000" <?php if ($currentLeaveCost == 10000) echo 'selected'; ?>>10k Golds</option>
            <option value="50000" <?php if ($currentLeaveCost == 50000) echo 'selected'; ?>>50k Golds</option>
            <option value="100000" <?php if ($currentLeaveCost == 100000) echo 'selected'; ?>>100k Golds</option>
        </select>
</div>
<button class="btn theme-btn w-100" type="submit">Save Changes</button>
</form>
    </div>
  </section>
  <!-- request details section end -->







  <!-- feather js -->
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/custom-feather.js"></script>

  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- script js -->
  <script src="assets/js/script.js"></script>
</body>

</html>
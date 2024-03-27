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
  <title>Host Cnter</title>
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
          <i class="notification-icon" data-feather="arrow-left"></i>
        </a>
        <h2>My Agency</h2>

        <div class="dropdown">
          <a href="#" class="back-btn" role="button" data-bs-toggle="dropdown">
            <i class="icon" data-feather="settings"></i>
          </a>

          <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="leave-agency.php">Leave Agency</a></li>
          <li><a class="dropdown-item" href="report-agency.php">Report Agency</a></li>
          </ul>
        </div>
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
    $sql = "SELECT agency.image FROM users INNER JOIN agency ON users.agency_id = agency.id WHERE users.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<img class='img-fluid profile-pic' src='../images/{$userData['image']}'  alt='p3'>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
          </div>
        </div>
        <h2>
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
    $sql = "SELECT agency.name, agency.flag FROM users INNER JOIN agency ON users.agency_id = agency.id WHERE users.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<div>{$userData['name']}<img src='../images/{$userData['flag']}' alt='' width='28' height='28'></div>";
          } else {
        echo "User with UID $userId not found.";
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
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve user data based on the user ID
    $sql = "SELECT agency.bio, agency.flag FROM users INNER JOIN agency ON users.agency_id = agency.id WHERE users.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "{$userData['bio']}";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
        </h5>
      </div>


        <!-- wallet details section starts-->
  <section>
    <div class="wallet-details">
      <div class="amount w-50 text-center">
        <div class="d-flex align-items-center justify-content-center">
          <h5>Agency ID</h5>
        </div>
        <h3 class="dark-text fw-semibold">
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
    $sql = "SELECT * FROM users WHERE uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "{$userData['agency_id']}";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
        </h3>
      </div>
      <div class="amount w-50 text-center border-0">
        <div class="d-flex align-items-center justify-content-center">
          <h5>Monthly Golds</h5>
        </div>
        <h3 class="dark-text fw-semibold">
        <?php
// تعريف الدالة التي تحول الأرقام إلى تنسيق مع الحروف "k" و "M" و "B"
function formatNumber($number) {
    if ($number < 1000) {
        return $number;
    } elseif ($number < 1000000) {
        return round($number / 1000, 1) . 'k';
    } elseif ($number < 1000000000) {
        return round($number / 1000000, 1) . 'M';
    } else {
        return round($number / 1000000000, 1) . 'B';
    }
}

require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Get the current month and year
    $currentMonth = date('m');
    $currentYear = date('Y');

    // Query to retrieve agency_id based on the user's UID
    $sql = "SELECT agency_id FROM users WHERE uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch agency_id
        $row = $result->fetch_assoc();
        $agencyId = $row['agency_id'];

        // Query to calculate total_profit for the agency for the current month
        $sql = "SELECT SUM(agency_profit + owner_profit + receiver_profit) AS total_profit
                FROM (
                    SELECT SUM(agency_profit) AS agency_profit, 
                           SUM(owner_profit) AS owner_profit, 
                           SUM(receiver_profit) AS receiver_profit
                    FROM `gifts_history_details` 
                    JOIN `users` ON users.uid = gifts_history_details.receiver_uid 
                    JOIN `gifts` ON gifts.id = gifts_history_details.gift_id 
                    WHERE users.agency_id = '$agencyId' AND 
                          DAY(gifts_history_details.created_at) >= 1 AND 
                          DAY(gifts_history_details.created_at) <= 31 AND
                          MONTH(gifts_history_details.created_at) = '$currentMonth' AND 
                          YEAR(gifts_history_details.created_at) = '$currentYear'
                ) AS subquery";

        // Execute the query
        $result = $conn->query($sql);

        // Check if the query was successful
        if ($result && $result->num_rows > 0) {
            // Fetch total_profit data
            $totalProfitData = $result->fetch_assoc();

            // Use total_profit data as needed
            echo formatNumber($totalProfitData['total_profit']);
        } else {
            echo "No data found for agency with ID $agencyId for the current month.";
        }
    } else {
        echo "User with UID $userId not found or not associated with any agency.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
        </h3>
      </div>
    </div>
  </section>
  <!-- wallet details section end-->

    <!-- categories section starts -->
    <section>
    <div class="custom-container">
      <div class="title">
        <h2>Agency Leader</h2>
      </div>
      
      <div class="row gy-3">
        <div class="col-12">
          <div class="transaction-box">
            <a href="#transaction-detail" data-bs-toggle="modal" class="d-flex gap-3">
              <div class="categories-image color1">
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
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.owner_uid, b.image, a.agency_id, u.profile_pic as owner_profilepic
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.owner_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<img class='img-fluid transaction-icon' src='../images/{$userData['owner_profilepic']}'  alt=''>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
              </div>
              <div class="transaction-details">
                <div class="transaction-name pb-0">
                  <h5>
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
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.owner_uid, b.image, a.agency_id, u.full_name as owner_name
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.owner_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<b><span style='color:red;'>{$userData['owner_name']}</span></b>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
                  </h5>
                  <h5 class="dark-text fw-semibold">ID : 
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
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.owner_uid, b.image, a.agency_id, u.short_digital_id as owner_displayid
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.owner_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<b><span style='color:blue;'>{$userData['owner_displayid']}</span></b>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
                  </h5>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- categories section end -->



      <!-- categories section starts -->
      <section>
    <div class="custom-container">
      <div class="title">
        <h2>Agency CO-Leader</h2>
      </div>
      
      <div class="row gy-3">
        <div class="col-12">
          <div class="transaction-box">
            <a href="#transaction-detail" data-bs-toggle="modal" class="d-flex gap-3">
              <div class="categories-image color1">
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
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.co_founder_uid, b.image, a.agency_id, u.profile_pic as owner_profilepic
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.co_founder_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<img class='img-fluid transaction-icon' src='../images/{$userData['owner_profilepic']}'  alt=''>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
              </div>
              <div class="transaction-details">
                <div class="transaction-name pb-0">
                  <h5>
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
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.co_founder_uid, b.image, a.agency_id, u.full_name as owner_name
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.co_founder_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<b><span style='color:orange;'>{$userData['owner_name']}</span></b>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
                  </h5>
                  <h5 class="dark-text fw-semibold">ID : 
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
    $sql = "SELECT a.id, b.id, a.uid, a.short_digital_id, a.full_name as userfullname, a.profile_pic, a.level, b.name, b.co_founder_uid, b.image, a.agency_id, u.short_digital_id as owner_displayid
    FROM users AS a
    INNER JOIN agency AS b ON a.agency_id = b.id
    INNER JOIN users AS u ON u.uid = b.co_founder_uid
    WHERE a.uid = '$userId'";
    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $userData = $result->fetch_assoc();

        // Use user data as needed
        echo "<b><span style='color:blue;'>{$userData['owner_displayid']}</span></b>";
    } else {
        echo "User with UID $userId not found.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Custom header '$customHeaderName' not found in the request.";
}
?>
                  </h5>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- categories section end -->




  

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
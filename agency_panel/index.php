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
  <title>Agency Panel</title>
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

  <!-- iconsax css -->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/iconsax.css" />


  <!-- bootstrap css -->
  <link rel="stylesheet" id="rtl-link" type="text/css" href="assets/css/vendors/bootstrap.min.css" />

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


  <!-- swiper css -->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/swiper-bundle.min.css" />

  <!-- Theme css -->
  <link rel="stylesheet" id="change-link" type="text/css" href="assets/css/style.css" />
</head>

<body>

  <!-- card start -->
  <section class="section-b-space">
    <div class="custom-container">
      <div class="card-box">
        <div class="card-details">
          <div class="d-flex justify-content-between">
            <h5 class="fw-semibold">Total Golds</h5>
            <img src="assets/images/svg/ellipse.svg" alt="ellipse" />
          </div>

          <h1 class="mt-2 text-white">
          <?php
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

            // Query to calculate total_profit for the agency for the current month
            $sql = "SELECT 'total' AS id, NULL AS title, NULL AS icon, 
                           FORMAT(SUM(agency_profit + owner_profit + receiver_profit), 0) AS total_profit, NULL AS created_at
                    FROM (
                        SELECT users.uid AS id, full_name AS title, users.profile_pic AS icon, 
                               SUM(agency_profit) AS agency_profit, 
                               SUM(owner_profit) AS owner_profit, 
                               SUM(receiver_profit) AS receiver_profit, 
                               gifts_history_details.created_at  
                        FROM `gifts_history_details` 
                        JOIN `users` ON users.uid = gifts_history_details.receiver_uid 
                        JOIN `gifts` ON gifts.id = gifts_history_details.gift_id 
                        WHERE users.agency_id = '$agencyId' AND 
                              DAY(gifts_history_details.created_at) >= 1 AND 
                              DAY(gifts_history_details.created_at) <= 31 AND
                              MONTH(gifts_history_details.created_at) = '$currentMonth' AND 
                              YEAR(gifts_history_details.created_at) = '$currentYear'
                        GROUP BY users.uid 
                    ) AS subquery";

            // Execute the query
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result && $result->num_rows > 0) {
                // Fetch total_profit data
                $totalProfitData = $result->fetch_assoc();

                // Use total_profit data as needed
                echo "{$totalProfitData['total_profit']}";
            } else {
                echo "No data found for agency with ID $agencyId for the current month.";
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

          </h1>

          <div class="amount-details">
            <div class="amount w-50 text-start">
              <div class="d-flex align-items-center justify-content-start">
                <h5>Last Week(Golds)</h5>
              </div>
              <h3 class="text-white">
              <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Get the current year
    $currentYear = date('Y');

    // Calculate the previous week
    $previousWeek = date('W') - 1;

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

            // Query to calculate total_profit for the agency for the previous week
            $sql = "SELECT 'total' AS id, NULL AS title, NULL AS icon, 
                           FORMAT(SUM(agency_profit + owner_profit + receiver_profit), 0) AS total_profit, NULL AS created_at
                    FROM (
                        SELECT users.uid AS id, full_name AS title, users.profile_pic AS icon, 
                               SUM(agency_profit) AS agency_profit, 
                               SUM(owner_profit) AS owner_profit, 
                               SUM(receiver_profit) AS receiver_profit, 
                               gifts_history_details.created_at  
                        FROM `gifts_history_details` 
                        JOIN `users` ON users.uid = gifts_history_details.receiver_uid 
                        JOIN `gifts` ON gifts.id = gifts_history_details.gift_id 
                        WHERE users.agency_id = '$agencyId' AND 
                              WEEK(gifts_history_details.created_at) = '$previousWeek' AND 
                              YEAR(gifts_history_details.created_at) = '$currentYear'
                        GROUP BY users.uid 
                    ) AS subquery";

            // Execute the query
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result && $result->num_rows > 0) {
                // Fetch total_profit data
                $totalProfitData = $result->fetch_assoc();

                // Use total_profit data as needed
                echo "{$totalProfitData['total_profit']}";
            } else {
                echo "No data found for agency with ID $agencyId for the previous week.";
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

              </h3>
            </div>
            <div class="amount w-50 text-end border-0">
              <div class="d-flex align-items-center justify-content-end">
                <h5>Last Month(Golds)</h5>
              </div>
              <h3 class="text-white">
              <?php
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

    // Calculate the previous month and year
    $previousMonth = date('m', strtotime('-1 month'));
    $previousYear = date('Y', strtotime('-1 month'));

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

            // Query to calculate total_profit for the agency for the previous month
            $sql = "SELECT 'total' AS id, NULL AS title, NULL AS icon, 
                           FORMAT(SUM(agency_profit + owner_profit + receiver_profit), 0) AS total_profit, NULL AS created_at
                    FROM (
                        SELECT users.uid AS id, full_name AS title, users.profile_pic AS icon, 
                               SUM(agency_profit) AS agency_profit, 
                               SUM(owner_profit) AS owner_profit, 
                               SUM(receiver_profit) AS receiver_profit, 
                               gifts_history_details.created_at  
                        FROM `gifts_history_details` 
                        JOIN `users` ON users.uid = gifts_history_details.receiver_uid 
                        JOIN `gifts` ON gifts.id = gifts_history_details.gift_id 
                        WHERE users.agency_id = '$agencyId' AND 
                              MONTH(gifts_history_details.created_at) = '$previousMonth' AND 
                              YEAR(gifts_history_details.created_at) = '$previousYear'
                        GROUP BY users.uid 
                    ) AS subquery";

            // Execute the query
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result && $result->num_rows > 0) {
                // Fetch total_profit data
                $totalProfitData = $result->fetch_assoc();

                // Use total_profit data as needed
                echo "{$totalProfitData['total_profit']}";
            } else {
                echo "No data found for agency with ID $agencyId for the previous month.";
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
              </h3>
            </div>
          </div>
        </div>
        <a href="#" class="add-money theme-color" data-bs-toggle="modal">Support</a>
      </div>
    </div>
  </section>
  <!-- card end -->

    <!-- wallet details section starts-->
    <section>
    <div class="wallet-details">
      <div class="amount w-50 text-center">
        <div class="d-flex align-items-center justify-content-center">
          <h5>Agency Balance</h5>
        </div>
        <h3 class="dark-text fw-semibold">
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
            $sql = "SELECT balance FROM agency WHERE id = '$agencyId'";

            // Execute the query
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result && $result->num_rows > 0) {
                // Fetch total_profit data
                $balance = $result->fetch_assoc();

                // Use total_profit data as needed
                echo "<span style='color: orange;'>" . number_format($balance['balance'], 0) . " Golds</span>"; // سيظهر الرقم مع اثنين من الأرقام بعد الفاصلة العشرية
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
        </h3>
      </div>
      <div class="amount w-50 text-center border-0">
        <div class="d-flex align-items-center justify-content-center">
          <h5>Balance in Dollars</h5>
        </div>
        <h3 class="dark-text fw-semibold">
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
            $sql = "SELECT balance FROM agency WHERE id = '$agencyId'";

            // Execute the query
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result && $result->num_rows > 0) {
                // Fetch total_profit data
                $balance = $result->fetch_assoc();

                // Conversion of balance to dollars
                $conversionQuery = "SELECT dollar_amount FROM gold_to_dollar WHERE gold_amount = 700";
                $conversionResult = $conn->query($conversionQuery);

                if ($conversionResult && $conversionResult->num_rows > 0) {
                    $conversionData = $conversionResult->fetch_assoc();
                    $conversionRate = $conversionData['dollar_amount'];

                    // Convert balance to dollars using conversion rate
                    $balanceInDollars = round($balance['balance'] / 700 * $conversionRate, 2);

                    // Use balance in dollars as needed
                    echo "<span style='color: green;'>{$balanceInDollars} $</span><br>";
                  } else {
                    echo "Conversion rate not found.";
                }
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
        </h3>
      </div>
    </div>
  </section>
  <!-- wallet details section end-->

    <!-- monthly statistics section starts -->
    <section>
    <div class="custom-container">
      <div class="statistics-banner">
        <div class="d-flex justify-content-center gap-3">
          <div class="img-fluid news-update-image">
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
            $sql = "SELECT image FROM agency WHERE id = '$agencyId'";

            // Execute the query
            $result = $conn->query($sql);

            // Check if the query was successful
            if ($result && $result->num_rows > 0) {
                // Fetch total_profit data
                $image = $result->fetch_assoc();

                // Use total_profit data as needed
                echo "<img src='../images/{$image['image']}' alt='' width='38' height='38'>";
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
          </div>
          <div class="statistics-content d-block">
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

            </h5>
            <h6>
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

            </h6>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- monthly statistics section end -->



  <!-- service section starts -->
  <section>
    <div class="custom-container">
      <div class="title">
        <h2>Select Options</h2>
        <a href="service.html">See all</a>
      </div>
      <div class="row gy-3">
        <div class="col-3">
          <a href="service.html">
            <div class="service-box">
              <i class="service-icon" data-feather="activity"></i>
            </div>
            <h5 class="mt-2 text-center dark-text">Ranks</h5>
          </a>
        </div>

        <div class="col-3">
          <a href="members-income.php">
            <div class="service-box">
              <i class="service-icon" data-feather="droplet"></i>
            </div>
            <h5 class="mt-2 text-center dark-text">Members income</h5>
          </a>
        </div>
        <div class="col-3">
          <a href="service.html">
            <div class="service-box">
              <i class="service-icon" data-feather="wifi"></i>
            </div>
            <h5 class="mt-2 text-center dark-text">Invite</h5>
          </a>
        </div>

        <div class="col-3">
          <a href="service.html">
            <div class="service-box">
              <i class="service-icon" data-feather="monitor"></i>
            </div>
            <h5 class="mt-2 text-center dark-text">Active members</h5>
          </a>
        </div>
        <div class="col-3">
          <a href="service.html">
            <div class="service-box">
              <i class="service-icon" data-feather="bar-chart-2"></i>
            </div>
            <h5 class="mt-2 text-center dark-text">Withdraw</h5>
          </a>
        </div>
        <div class="col-3">
          <a href="service.html">
            <div class="service-box">
              <i class="service-icon" data-feather="tablet"></i>
            </div>
            <h5 class="mt-2 text-center dark-text">Mobile</h5>
          </a>
        </div>
        <div class="col-3">
          <a href="service.html">
            <div class="service-box">
              <i class="service-icon" data-feather="plus-square"></i>
            </div>
            <h5 class="mt-2 text-center dark-text">Medical</h5>
          </a>
        </div>
        <div class="col-3">
          <a href="service.html">
            <div class="service-box">
              <i class="service-icon" data-feather="more-horizontal"></i>
            </div>
            <h5 class="mt-2 text-center dark-text">Other</h5>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- quick send section starts -->
  <section>
    <div class="custom-container">
      <div class="title">
        <h2>Quick send to</h2>
        <a href="scan-pay.html">See all</a>
      </div>
    </div>
    <div class="quick-send">
      <div class="profile">
        <a href="person-transaction.html">
          <img class="img-fluid person-img" src="assets/images/person/p5.png" alt="p5" />
          <h5>Johnny</h5>
        </a>
      </div>
    </div>
  </section>
  <!-- quick send section end -->




  <!-- Transaction section starts -->
  <section>
    <div class="custom-container">
      <div class="title">
        <h2>Transaction</h2>
        <a href="transaction-history.html">See all</a>
      </div>

      <div class="row gy-3">
        <div class="col-12">
          <div class="transaction-box">
            <a href="transaction-history.html" class="d-flex gap-3">
              <div class="transaction-image">
                <img class="img-fluid transaction-icon" src="assets/images/svg/1.svg" alt="p1" />
              </div>
              <div class="transaction-details">
                <div class="transaction-name">
                  <h5>Amazon prime</h5>
                  <h3 class="error-color">$199.<span>99</span></h3>
                </div>
                <div class="d-flex justify-content-between">
                  <h5 class="light-text">Subscription</h5>
                  <h5 class="light-text">8:45 am</h5>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-12">
          <div class="transaction-box">
            <a href="transaction-history.html" class="d-flex gap-3">
              <div class="transaction-image">
                <img class="img-fluid transaction-icon" src="assets/images/svg/2.svg" alt="p2" />
              </div>
              <div class="transaction-details">
                <div class="transaction-name">
                  <h5>Apple store</h5>
                  <h3 class="success-color">$60.<span>30</span></h3>
                </div>
                <div class="d-flex justify-content-between">
                  <h5 class="light-text">Installment</h5>
                  <h5 class="light-text">9:00 pm</h5>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-12">
          <div class="transaction-box">
            <a href="transaction-history.html" class="d-flex gap-3">
              <div class="transaction-image">
                <img class="img-fluid transaction-icon" src="assets/images/svg/3.svg" alt="p3" />
              </div>
              <div class="transaction-details">
                <div class="transaction-name">
                  <h5>Grocery shop</h5>
                  <h3 class="error-color">$55.<span>20</span></h3>
                </div>
                <div class="d-flex justify-content-between">
                  <h5 class="light-text">Purchase</h5>
                  <h5 class="light-text">20 May</h5>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-12">
          <div class="transaction-box">
            <a href="transaction-history.html" class="d-flex gap-3">
              <div class="transaction-image">
                <img class="img-fluid transaction-icon" src="assets/images/svg/4.svg" alt="p4" />
              </div>
              <div class="transaction-details">
                <div class="transaction-name">
                  <h5>Sanpchat sub</h5>
                  <h3 class="success-color">$18.<span>10</span></h3>
                </div>
                <div class="d-flex justify-content-between">
                  <h5 class="light-text">Bill pay</h5>
                  <h5 class="light-text">19 May</h5>
                </div>
              </div>
            </a>
          </div>
        </div>
        <div class="col-12">
          <div class="transaction-box">
            <a href="transaction-history.html" class="d-flex gap-3">
              <div class="transaction-image">
                <img class="img-fluid transaction-icon" src="assets/images/svg/5.svg" alt="p5" />
              </div>
              <div class="transaction-details">
                <div class="transaction-name">
                  <h5>Spotify music</h5>
                  <h3 class="success-color">$20.<span>50</span></h3>
                </div>
                <div class="d-flex justify-content-between">
                  <h5 class="light-text">Transfer</h5>
                  <h5 class="light-text">18 May</h5>
                </div>
              </div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Transaction section end -->






  <!-- panel-space start -->
  <section class="panel-space"></section>
  <!-- panel-space end -->




  <!-- swiper js -->
  <script src="assets/js/swiper-bundle.min.js"></script>
  <script src="assets/js/custom-swiper.js"></script>

  <!-- feather js -->
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/custom-feather.js"></script>

  <!-- iconsax js -->
  <script src="assets/js/iconsax.js"></script>

  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- homescreen popup js -->
  <script src="assets/js/homescreen-popup.js"></script>

  <!-- PWA offcanvas popup js -->
  <script src="assets/js/offcanvas-popup.js"></script>

  <!-- script js -->
  <script src="assets/js/script.js"></script>
</body>

</html>
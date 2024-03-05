<?php
include('config/dbcon.php');
include('config/script.php');

?>

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
  <title>Earnings</title>
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

  <!-- swiper css -->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/swiper-bundle.min.css" />

  <!-- Theme css -->
  <link rel="stylesheet" id="change-link" type="text/css" href="assets/css/style.css" />
</head>

<body>
  <!-- card start -->
  <section>
    <div class="custom-container">
      <div class="crypto-wallet-box">
        <div class="card-details">
          <div class="d-block w-75">
            <h5 class="fw-semibold">Total Golds</h5>
            <h2 class="mt-2">
            <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
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
        echo "{$userData['gold']}";
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
          </div>
          <div class="price-difference">
            <i class="menu-icon" data-feather="arrow-up"></i>
            <h6>
            <?php
require 'config/dbcon.php';
$customHeaderName = 'UID';

// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

    // Query to retrieve conversion rate from gold to dollars
    $conversionQuery = "SELECT dollar_amount FROM gold_to_dollar WHERE gold_amount = 700";
    $conversionResult = $conn->query($conversionQuery);

    if ($conversionResult && $conversionResult->num_rows > 0) {
        $conversionData = $conversionResult->fetch_assoc();
        $conversionRate = $conversionData['dollar_amount'];

        // Query to retrieve user's gold amount
        $userGoldQuery = "SELECT gold FROM users WHERE uid = '$userId'";
        $userGoldResult = $conn->query($userGoldQuery);

        if ($userGoldResult && $userGoldResult->num_rows > 0) {
            $userGoldData = $userGoldResult->fetch_assoc();
            $userGoldAmount = $userGoldData['gold'];

            // Convert user's gold to dollars using conversion rate
            $userDollars = round($userGoldAmount / 700 * $conversionRate, 2);

            // Use user's dollars as needed
            echo "$userDollars$<br>";
        } else {
            echo "User with UID $userId not found.";
        }
    } else {
        echo "Conversion rate not found.";
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
  <!-- card end -->
  <!-- categories section starts -->
  <section class="categories-section section-b-space">
    <div class="custom-container">
      <ul class="categories-list">
        <li>
          <a href="crypto-send.html">
            <div class="categories-box">
              <i class="categories-icon" data-feather="arrow-up"></i>
            </div>
            <h5 class="mt-2 text-center">Send</h5>
          </a>
        </li>
        <li>
          <a href="crypto-exchange.html">
            <div class="categories-box">
              <i class="categories-icon" data-feather="repeat"></i>
            </div>
            <h5 class="mt-2 text-center">Exchange</h5>
          </a>
        </li>

        <li>
          <a href="withdraw.php">
            <div class="categories-box">
              <i class="iconsax categories-icon" data-icon="bank"></i>
            </div>
            <h5 class="mt-2 text-center">Withdraw</h5>
          </a>
        </li>
      </ul>
    </div>
  </section>
  <!-- categories section end -->

  <!-- Buy & Sell history section starts -->
  <section>
    <div class="custom-container">
      <div class="title">
        <h2>Transaction History</h2>
      </div>

        <?php
// تحقق مما إذا كانت الطريقة المستخدمة هي POST
    require 'config/dbcon.php';
    $customHeaderName = 'UID';

    // التحقق مما إذا كان رأس الطلب الخاص بالمستخدم موجودًا
// Check if the custom header is set in the request
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // Retrieve the value of the custom header
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // Sanitize the user ID to prevent SQL injection
    $userId = $conn->real_escape_string($userId);

        // استعلام لاسترداد بيانات المستخدم بناءً على رقم المستخدم
        $sql = "SELECT * FROM withdraw_request WHERE uid = '$userId' ORDER BY submission_time DESC LIMIT 3";
        $result = $conn->query($sql);

        // التحقق مما إذا كان الاستعلام ناجحًا
        if ($result && $result->num_rows > 0) {
            // استخدام بيانات المستخدم حسب الحاجة
            while ($row = $result->fetch_assoc()) {
                // عرض الفاتورة بناءً على بيانات المستخدم المسترجعة
?>
          <div class="transaction-box">
            <a href="transaction-history.html" class="d-flex gap-3">
              <div class="transaction-image color3">
                <img class="img-fluid icon" src="trans.png" alt="litecoin" />
              </div>
              <div class="transaction-details">
                <div class="transaction-name">
                  <h5>#INV-<?php echo $row['id']; ?></h5>
                  <h3 class="success-color"><?php echo $row['dollarsamount']; ?>$</h3>
                </div>
                <div class="d-flex justify-content-between">
                  <h5 class="light-text"><?php echo $row['submission_time']; ?></h5>
                  <h5 class="text-warning"><?php echo $row['amount']; ?> Golds<span class="light-text"></span></h5>
                </div>
              </div>
            </a>
          </div>
          <?php
            }
        } else {
            echo "No invoices found for this user.";
        }

        // إغلاق الاتصال بقاعدة البيانات
        $conn->close();
    } else {
        echo "Custom header '$customHeaderName' not found in the request.";
    }

?>
        </div>
        </div>
  </section>
  <!-- Transaction section end -->



  <!-- panel-space start -->
  <section class="panel-space"></section>
  <!-- panel-space end -->


  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- swiper js -->
  <script src="assets/js/swiper-bundle.min.js"></script>
  <script src="assets/js/custom-swiper.js"></script>

  <!-- apexcharts js -->
  <script src="assets/js/apexcharts.js"></script>
  <script src="assets/js/custom-candlestick-chart.js"></script>

  <!-- feather js -->
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/custom-feather.js"></script>

  <!-- iconsax js -->
  <script src="assets/js/iconsax.js"></script>
  <!-- script js -->
  <script src="assets/js/script.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    document.getElementById("myForm").addEventListener("submit", function(event) {
        event.preventDefault(); // منع إرسال النموذج بشكل افتراضي
        var formData = new FormData(this); // جمع بيانات النموذج
        fetch('withdraw.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            Swal.fire({
                title: "تم الإرسال!",
                text: "شكراً لك، " + data + "!",
                icon: "success",
                confirmButtonText: "موافق"
            }).then(function() {
                window.location.href = "index.php";
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

</body>

</html>
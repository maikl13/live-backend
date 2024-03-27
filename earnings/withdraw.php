<?php
        include 'config/dbcon.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database configuration
    // Prepare and bind the SQL statement for inserting payment details
    $stmt_payment_details = $conn->prepare("INSERT INTO withdraw_request (payment_method, bank_address, paypal_email, western_union_details, uid, amount, dollarsamount, phone, country, iban, swiftcode, firstname, lastname) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Set parameters and execute for inserting payment details
    $stmt_payment_details->bind_param("sssssssssssss", $payment_method, $bank_address, $paypal_email, $western_union_details, $uid, $amount, $dollarsamount, $phone, $country, $iban, $swiftcode, $firstname, $lastname);

    $payment_method = $_POST['payment_method'];

    if ($payment_method === "bank") {
        $bank_address = $_POST['bank_address'];
        $paypal_email = "";
        $western_union_details = "";
    } elseif ($payment_method === "paypal") {
        $bank_address = "";
        $paypal_email = $_POST['paypal_email'];
        $western_union_details = "";
    } elseif ($payment_method === "western_union") {
        $bank_address = "";
        $paypal_email = "";
        $western_union_details = $_POST['western_union_details'];
    }

    // Retrieve UID, amount, phone, country, iban, swiftcode, firstname, and lastname from POST request
    $uid = $_POST['uid'];
    $amount = $_POST['amount'];
    $dollarsamount = $_POST['dollarsamount']; // New field for home address
    $phone = $_POST['phone'];
    $country = $_POST['country'];
    $iban = $_POST['iban'];
    $swiftcode = $_POST['swiftcode'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];

    // Check if the user has enough gold
    $check_gold_query = "SELECT gold FROM users WHERE uid = '$uid'";
    $result = $conn->query($check_gold_query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $user_gold = $row["gold"];

        if ($user_gold >= $amount) {
            // Execute the SQL statement for inserting payment details
            $stmt_payment_details->execute();

            // Update user's gold balance after successful transaction
            $new_gold_balance = $user_gold - $amount;
            $update_gold_query = "UPDATE users SET gold = '$new_gold_balance' WHERE uid = '$uid'";
            $conn->query($update_gold_query);

            // Update order status to "Pending"
            $update_order_status_query = "UPDATE withdraw_request SET status = 'pending' WHERE id = ?";
            $conn->query($update_order_status_query);

            // Redirect to success page
            header("Location: success.php");
        } else {
            // Redirect to error page if user doesn't have enough gold
            header("Location: error.php");
        }
    } else {
        echo "User not found.";
    }

    // Close the prepared statements and database connection
    $stmt_payment_details->close();
    $conn->close();
}
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
  <title>Live</title>
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
        <a href="landing.html" class="back-btn">
          <i class="icon" data-feather="arrow-left"></i>
        </a>
        <h2>Withdraw</h2>
      </div>
    </div>
  </header>
  <!-- header end -->

  <!-- Withdraw section starts -->
  <section class="section-b-space">
    <div class="custom-container">
      <div class="title">
        <h2>Money withdraw from</h2>
      </div>
      
      <ul class="select-bank">
        <li>
          <div class="balance-box active">
            <input class="form-check-input" type="radio" name="flexRadio" checked />
            <img class="img-fluid balance-box-img active" src="assets/images/svg/balance-box-bg-active.svg"
              alt="balance-box" />
            <img class="img-fluid balance-box-img unactive" src="assets/images/svg/balance-box-bg.svg"
              alt="balance-box" />
            <div class="balance-content">
              <h6>Balance</h6>
              <h3>
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

              </h3>
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

              </h5>
            </div>
          </div>
        </li>
        <li>
      </ul>
      <div class="title">
        <h2>Money Wthdraw</h2>
      </div>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="auth-form p-0" target="_blank">
        <div class="form-group">
        <input type="hidden" name="uid" class="form-control" value="<?php echo $userId; ?>">
          <label for="inputbankname" class="form-label">Withdrawal Method</label>
          <select id="payment_method" class="form-select" name="payment_method" onchange="showFields()">
          <option selected>-- Select Method --</option>
        <option value="bank">Bank</option>
        <option value="paypal">PayPal</option>
        <option value="western_union">Western Union</option>
    </select>
    <div id="bank_fields" style="display:none;">
        <label for="bank_address">Bank Name:</label>
        <input type="text" id="bank_address" class="form-control" name="bank_address"></textarea>
    </div>
    <div id="iban" style="display:none;">
        <label for="bank_address">IBAN:</label>
        <input type="text" id="iban" class="form-control" name="iban"></textarea>
    </div>
    <div id="swiftcode" style="display:none;">
        <label for="swiftcode">BIC/SWIFT Code:</label>
        <input type="text" id="swiftcode" class="form-control" name="swiftcode"></textarea>
    </div>
    <div id="firstname" style="display:none;">
        <label for="firstname">First Name:</label>
        <input type="text" class="form-control" name="firstname"></textarea>
    </div>
    <div id="lastname" style="display:none;">
        <label for="lastname">Last Name:</label>
        <input type="text" class="form-control" name="lastname"></textarea>
    </div>



    <div id="paypal_fields" style="display:none;">
        <label for="paypal_email">PayPal Email:</label>
        <input type="email" id="paypal_email" class="form-control" name="paypal_email">
    </div>

    <div id="western_union_fields" style="display:none;">
        <label for="western_union_details">Western Union Details:</label>
        <textarea id="western_union_details" class="form-control" name="western_union_details"></textarea>
    </div>


        <div class="form-group">
        <label for="phone">Country:</label>
        <select id="country" name="country" class="form-control">
        <option value="" disabled selected>Select a country</option>
    </select>
    </div>

    <div class="form-group">
    <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phone" class="form-control">
        </div>

        <div class="form-group">
        <label for="amount" class="form-label">Amount (Golds)</label>
        <input type="number" id="amount" name="amount" class="form-control" required>
        </div>

        <div class="form-group">
        <h5 id="dollarsamounttext">Amount in dollars</h5>
        </div>


        <div class="form-group">
        <input type="hidden" id="dollarsamount" name="dollarsamount" class="form-control" readonly>
        </div>
        

        <button class="btn theme-btn w-100" type="submit">Submit</button>
      </form>
    </div>
  </section>
  <!-- Withdraw section end -->


  <!-- feather js -->
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/custom-feather.js"></script>

  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- script js -->
  <script src="assets/js/script.js"></script>

  <script>
function showFields() {
    var selectedOption = document.getElementById("payment_method").value;

    // Hide all fields first
    document.getElementById("bank_fields").style.display = "none";
    document.getElementById("iban").style.display = "none";
    document.getElementById("swiftcode").style.display = "none";
    document.getElementById("firstname").style.display = "none";
    document.getElementById("lastname").style.display = "none";
    document.getElementById("paypal_fields").style.display = "none";
    document.getElementById("western_union_fields").style.display = "none";

    // Show the appropriate field based on the selected option
    if (selectedOption === "bank") {
      document.getElementById("bank_fields").style.display = "block";
      document.getElementById("iban").style.display = "block";
      document.getElementById("swiftcode").style.display = "block";
      document.getElementById("firstname").style.display = "block";
      document.getElementById("lastname").style.display = "block";
    } else if (selectedOption === "paypal") {
        document.getElementById("paypal_fields").style.display = "block";
    } else if (selectedOption === "western_union") {
        document.getElementById("western_union_fields").style.display = "block";
    }
}

// Call showFields() initially to show fields based on default selected option
showFields();
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
        document.getElementById("amount").addEventListener("input", function() {
            var goldAmount = parseFloat(this.value);
            var conversionRate = 700; // Assume conversion rate is fixed

            // Calculate dollars amount
            var dollarsAmount = (goldAmount / conversionRate).toFixed(2);

            // Display dollars amount
            document.getElementById("dollarsamount").value = dollarsAmount;
        });
    </script>

<script>
        document.getElementById("amount").addEventListener("input", function() {
            var goldAmount = parseFloat(this.value);
            var conversionRate = 700; // Assume conversion rate is fixed

            // Calculate dollars amount
            var dollarsAmount = (goldAmount / conversionRate).toFixed(2);

            // Display dollars amount
            document.getElementById("dollarsamounttext").textContent = "Amount in Dollars: $" + dollarsAmount;
        });
    </script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
        $(document).ready(function() {
            // Fetch country data from REST Countries API
            $.ajax({
                url: 'https://restcountries.com/v3.1/all',
                dataType: 'json',
                success: function(data) {
                    // Populate select box with country options
                    var countrySelect = $('#country');
                    $.each(data, function(index, country) {
                        var countryName = country.name.common;
                        var countryCode = country.cca2;
                        countrySelect.append($('<option>').text(countryName).attr('value', countryCode));
                    });

                    // Filter countries based on search input
                    $('#search').on('input', function() {
                        var searchText = $(this).val().toLowerCase();
                        countrySelect.find('option').each(function() {
                            var optionText = $(this).text().toLowerCase();
                            if (optionText.indexOf(searchText) !== -1) {
                                $(this).show();
                            } else {
                                $(this).hide();
                            }
                        });
                    });
                }
            });
        });
    </script>


</body>

</html>
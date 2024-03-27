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
  <title>Leave Agency</title>
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

<body class="auth-body">
  <!-- header starts -->
  <div class="auth-header">
    <div class="help-head d-flex">
      <a href="index.php"> <i class="back-btn" data-feather="arrow-left"></i> </a>
      <h2>Leave Agency</h2>
    </div>
    <div class="head-img text-center">
      <img class="img-fluid img2" src="assets/images/authentication/help.svg" alt="v1" />
    </div>
  </div>
  <!-- header end -->

  <!-- help section start -->
    <div class="custom-container">
      <div class="help-center">
        <h2 class="fw-semibold">You can exit the agency</h2>
        <div class="accordion accordion-flush help-accordion" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseOne">Pre-Consideration</button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">Before deciding to exit the agency within the application, we encourage you to carefully consider the reasons driving your desire to leave, ensuring it is a well-thought-out and appropriate decision. Exiting the agency may have implications on your account and your relationship with users, so please consider this carefully.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#flush-collapseTwo">Costs and Requirements</button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">If you decide to proceed and exit the agency, please be aware that there is a cost associated with this action. "Golds" will be deducted from your account as the cost for the exit. Please refer to the terms and conditions for detailed information on expected fees.</div>
            </div>
          </div>
          </div>
        </div>
      </div>
    </div>
    
    <div>
    <?php
    // Include database connection file
    include('config/dbcon.php');

    // Get the UID from the HTTP header
    $userId = $_SERVER['HTTP_UID'];

    // Query to retrieve the leave cost from the agency table based on the user's agency_id
    $sql = "SELECT a.leave_cost 
            FROM agency a 
            INNER JOIN users u ON a.id = u.agency_id 
            WHERE u.uid = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch leave cost from the first row (assuming only one row is returned)
        $row = $result->fetch_assoc();
        $leave_cost = $row["leave_cost"];

        // Display leave cost value as the button text
        echo "<form action='leave-agency-code.php' method='post'>";
        echo "<input type='hidden' name='uid' id='uidInput' value='$userId'>";
        echo "<button type='submit' name='leave' class='btn theme-btn w-100'>Leave This Agency ($leave_cost Golds)</button>";
        echo "</form>";
    } else {
        echo "Leave cost not found for the user's agency.";
    }

    // Close database connection
    $conn->close();
    ?>  <!-- help section end -->



  <!-- feather js -->
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/custom-feather.js"></script>

  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- script js -->
  <script src="assets/js/script.js"></script>

  <script>
    // جلب الـ UID عند تحميل الصفحة
    var uid = "<?php echo $_SERVER['HTTP_UID']; ?>";
    // تعيين قيمة الـ UID في حقل الإدخال المخفي
    document.getElementById('uidInput').value = uid;
</script>

</body>

</html>
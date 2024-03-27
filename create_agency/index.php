<?php
        include 'config/dbcon.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
          // استلام البيانات من النموذج
    $agency_name = $_POST['agency_name'];
    $owner_id = $_POST['owner_id'];
    $owner_name = $_POST['owner_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $total_hosts = $_POST['total_hosts'];

    // عملية الإدراج
    $sql = "INSERT INTO request_create_agency (agency_name, owner_id, owner_name, phone, email, total_hosts)
    VALUES ('$agency_name', '$owner_id', '$owner_name', '$phone', '$email', '$total_hosts')";

    if ($conn->query($sql) === TRUE) {
        // تمت عملية الإدراج بنجاح - قم بتوجيه المستخدم إلى success.php
        header("Location: success.php");
        exit; // تأكد من إيقاف التنفيذ بعد التوجيه
    } else {
        echo "خطأ: " . $sql . "<br>" . $conn->error;
    }

    // إغلاق الاتصال
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
  <title>Create Agency</title>
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
        <a href="profile.html" class="back-btn">
          <i class="icon" data-feather="arrow-left"></i>
        </a>
        <h2>Create Agency</h2>
      </div>
    </div>
  </header>
  <!-- header end -->

  <!-- my account section start -->
  <section class="section-b-space">
    <div class="custom-container">
      <div class="profile-section">
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="auth-form p-0" target="_blank">
        <div class="form-group">
          <label for="agency_name" class="form-label">Agency Name</label>
          <input type="text" class="form-control" id="agency_name"  name="agency_name"
            placeholder="Enter Agency Name" />
        </div>
        <div class="form-group">
          <label for="owner_id" class="form-label">Owner ID</label>
          <input type="text" class="form-control" id="owner_id" name="owner_id"
            placeholder="Enter Account ID" />
        </div>
        <div class="form-group">
          <label for="owner_name" class="form-label">Your Name</label>
          <input type="text" class="form-control" id="owner_name" name="owner_name"
            placeholder="Enter Your Full Name" />
        </div>
        <div class="form-group">
          <label for="phone" class="form-label">Phone Number</label>
          <input type="phone" class="form-control" id="phone" name="phone"
            placeholder="Enter Your Phone Number" />
        </div>
        <div class="form-group">
          <label for="email" class="form-label">E-mail Address</label>
          <input type="email" class="form-control" id="email" name="email"
            placeholder="Enter Your Email Address" />
        </div>
        <div class="form-group">
          <label for="total_hosts" class="form-label">How many hosts you have (1-10000)</label>
          <input type="number" class="form-control" id="total_hosts" name="total_hosts"
            placeholder="How many hosts you have" />
        </div>
        </div>
        <button class="btn theme-btn w-100" type="submit">Create Agency</button>
        </form>
    </div>
  </section>
  <!-- my account section end -->

  <!-- feather js -->
  <script src="assets/js/feather.min.js"></script>
  <script src="assets/js/custom-feather.js"></script>

  <!-- bootstrap js -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- script js -->
  <script src="assets/js/script.js"></script>
</body>

</html>
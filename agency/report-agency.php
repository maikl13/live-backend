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
  <title>Report Agency</title>
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
        <h2>Report Agency</h2>
      </div>
    </div>
  </header>
  <!-- header end -->



  <?php
require 'config/dbcon.php';

$customHeaderName = 'UID';

// تحقق مما إذا كان الهيدر الخاص بالمستخدم موجود في الطلب
if (isset($_SERVER['HTTP_' . $customHeaderName])) {
    // استرجاع قيمة الهيدر المخصص
    $userId = $_SERVER['HTTP_' . $customHeaderName];

    // تنقيح معرف المستخدم لمنع حدوث إدخال SQL
    $userId = $conn->real_escape_string($userId);

    // استعلام SQL للعثور على معرف الوكالة باستخدام معرف المستخدم
    $query = "SELECT agency_id FROM users WHERE uid = '$userId'";

    // تنفيذ الاستعلام
    $result = $conn->query($query);

    // التحقق من وجود نتائج
    if ($result->num_rows > 0) {
        // استخراج الصف الأول من النتائج
        $row = $result->fetch_assoc();
        // الحصول على معرف الوكالة
        $agencyId = $row['agency_id'];
    }
}
?>
  <section class="section-b-space">
    <div class="custom-container">
    <form class="auth-form p-0" action="process_report.php" method="post">
            <div class="form-group">
            <input type="hidden" name="agency_id" value="<?php echo $agencyId; ?>">
            <input type="hidden" name="user_uid" value="<?php echo $userId; ?>">
                <label for="message" class="form-label">Reporting Details</label>
                <div class="form-input">
                    <textarea class="form-control" name="message" id="message" rows="3" placeholder="Write here"></textarea>
                </div>
            </div>
            <button type="submit" class="btn theme-btn w-100">Report</button>
        </form>
    </div>
</section>



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
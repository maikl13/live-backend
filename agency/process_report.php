<?php
include('config/dbcon.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// التحقق من أن النموذج قد تم إرساله
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استخراج البيانات المرسلة عبر النموذج
    $agencyId = $_POST['agency_id'];
    $userId = $_POST['user_uid'];
    $message = $_POST['message'];

    $currentDateTime = date('Y-m-d H:i:s');

    $sql = "INSERT INTO agency_hostsreports (agency_id, user_uid, message, datetime) VALUES ('$agencyId', '$userId', '$message', '$currentDateTime')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: success_report.php");
        exit(); // Terminate script after redirect
} else {
        echo "حدث خطأ أثناء الإدخال: " . mysqli_error($conn);
    }
}

// إغلاق اتصال قاعدة البيانات
mysqli_close($conn);

?>

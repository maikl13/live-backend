<?php
include('config/dbcon.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];

    // استعلام SQL للحصول على بيانات الطلب المطلوب
    $query = "SELECT user_uid FROM agency_join_request WHERE request_id = '$request_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $user_uid = $row['user_uid'];

        // إضافة سجل جديد إلى جدول agency_join_request_log قبل عملية الحذف
        $insert_log_query = "INSERT INTO agency_join_request_log (request_id, agency_id, user_uid, request_date, status, action_date) 
                             VALUES ('$request_id', (SELECT agency_id FROM agency_join_request WHERE request_id = '$request_id'), '$user_uid', NOW(), 'rejected', NOW())";
        $insert_log_result = mysqli_query($conn, $insert_log_query);

        if ($insert_log_result) {
            // قم بحذف السجل من جدول agency_join_request بعد التحديث بنجاح
            $delete_query = "DELETE FROM agency_join_request WHERE request_id = '$request_id'";
            $delete_result = mysqli_query($conn, $delete_query);

            if ($delete_result) {
                // توجيه المستخدم إلى صفحة النجاح بعد حذف السجل بنجاح
                header("Location: success.php");
                exit();
            } else {
                // توجيه المستخدم إلى صفحة الخطأ في حالة فشل حذف السجل
                header("Location: error.php?message=delete_error");
                exit();
            }
        } else {
            // توجيه المستخدم إلى صفحة الخطأ في حالة فشل إضافة سجل الطلب إلى سجل الوكالة
            header("Location: error.php?message=log_insert_error");
            exit();
        }
    } else {
        // توجيه المستخدم إلى صفحة الخطأ إذا لم يتم العثور على الطلب
        header("Location: error.php?message=request_not_found");
        exit();
    }
} else {
    // توجيه المستخدم إلى صفحة الخطأ إذا كان الطلب غير صالح
    header("Location: error.php?message=invalid_request");
    exit();
}
?>

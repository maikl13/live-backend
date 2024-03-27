<?php
include('config/dbcon.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// التحقق من وجود طلب POST والتحقق من وجود المعرف
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['request_id'])) {
    $request_id = $_POST['request_id'];

    // استعلام SQL للحصول على بيانات الطلب المطلوب
    $query = "SELECT user_uid FROM agency_join_request WHERE request_id = '$request_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $user_uid = $row['user_uid'];

        // التحقق مما إذا كانت قيمة "agency_id" في الجدول "users" فارغة
        $check_query = "SELECT agency_id FROM users WHERE uid = '$user_uid'";
        $check_result = mysqli_query($conn, $check_query);

        if ($check_result && mysqli_num_rows($check_result) == 1) {
            $check_row = mysqli_fetch_assoc($check_result);
            if (is_null($check_row['agency_id'])) {
                // إذا كانت قيمة "agency_id" في جدول "users" فارغة، قم بتحديث السجل
                $update_query = "UPDATE users SET agency_id = (SELECT agency_id FROM agency_join_request WHERE request_id = '$request_id') WHERE uid = '$user_uid'";
                $update_result = mysqli_query($conn, $update_query);

                if ($update_result) {
                    // إضافة سجل جديد إلى جدول agency_join_request_log قبل عملية الحذف
                    $insert_log_query = "INSERT INTO agency_join_request_log (request_id, agency_id, user_uid, request_date, status, action_date) 
                                         VALUES ('$request_id', (SELECT agency_id FROM agency_join_request WHERE request_id = '$request_id'), '$user_uid', NOW(), 'approved', NOW())";
                    $insert_log_result = mysqli_query($conn, $insert_log_query);

                    if ($insert_log_result) {
                        // تاريخ الآن

                        // إدخال بيانات الإشعار إلى جدول agency_notifications
                        $insert_notification_query = "INSERT INTO agency_notifications (user_uid, agency_id, message, read_status, datetime) 
                                                      VALUES ('$user_uid', (SELECT agency_id FROM agency_join_request WHERE request_id = '$request_id'), 'Join the agency', 0, NOW())";
                        $insert_notification_result = mysqli_query($conn, $insert_notification_query);

                        if ($insert_notification_result) {
                            // حذف السجل من جدول agency_join_request بعد التحديث بنجاح
                            $delete_query = "DELETE FROM agency_join_request WHERE request_id = '$request_id'";
                            $delete_result = mysqli_query($conn, $delete_query);

                            if ($delete_result) {
                                // توجيه المستخدم إلى صفحة النجاح بعد حذف السجل بنجاح
                                header("Location: success.php");
                                exit();
                            } else {
                                // توجيه المستخدم إلى صفحة الخطأ في حالة فشل حذف السجل
                                header("Location: error.php5");
                                exit();
                            }
                        } else {
                            // توجيه المستخدم إلى صفحة الخطأ في حالة فشل إضافة بيانات الإشعار
                            header("Location: error.php4");
                            exit();
                        }
                    } else {
                        // توجيه المستخدم إلى صفحة الخطأ في حالة فشل إضافة سجل الطلب إلى سجل الوكالة
                        header("Location: error.php43");
                        exit();
                    }
                } else {
                    // توجيه المستخدم إلى صفحة الخطأ في حالة فشل التحديث
                    header("Location: error.php34");
                    exit();
                }
            } else {
                // توجيه المستخدم إلى صفحة الخطأ إذا كانت قيمة "agency_id" موجودة بالفعل
                header("Location: error.php");
                exit();
            }
        } else {
            // توجيه المستخدم إلى صفحة الخطأ إذا لم يتم العثور على المستخدم
            header("Location: error.php2222");
            exit();
        }
    } else {
        // توجيه المستخدم إلى صفحة الخطأ إذا لم يتم العثور على الطلب
        header("Location: error.php444");
        exit();
    }
} else {
    // توجيه المستخدم إلى صفحة الخطأ إذا كان الطلب غير صالح
    header("Location: error.php56645");
    exit();
}


?>

<?php
include('config/dbcon.php');

$short_digital_id = $_POST['short_digital_id'];

// استعلام SQL لجلب معلومات المستخدم باستخدام الـ UID المدخل
$sql = "SELECT full_name, bio, uid FROM users WHERE short_digital_id = '$short_digital_id'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // جلب بيانات المستخدم
    $row = $result->fetch_assoc();
    $user_info = array(
        'full_name' => $row['full_name'],
        'bio' => $row['bio'],
        'uid' => $row['uid']
    );
    
    // إرجاع بيانات المستخدم بتنسيق JSON
    echo json_encode($user_info);
} else {
    // إرجاع رسالة خطأ في حالة عدم العثور على المستخدم
    echo "User not found";
}

// إغلاق الاتصال بقاعدة البيانات
$con->close();
?>

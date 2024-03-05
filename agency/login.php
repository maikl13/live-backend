<?php
// تفعيل الجلسات
session_start();
include('config/dbcon.php');


// التحقق من إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // استلام بيانات الدخول من النموذج
    $uid = $_POST["uid"];

    // استعلام للتحقق من صحة بيانات الدخول
    $sql = "SELECT * FROM users WHERE uid = '$uid'";
    $result = $con->query($sql);

    if ($result->num_rows == 1) {
        // نجاح تسجيل الدخول
        $row = $result->fetch_assoc();

        // تسجيل بيانات الجلسة
        $_SESSION["uid"] = $row["uid"];
        $_SESSION["uid"] = $row["uid"];
        $_SESSION["agency_id"] = $row["agency_id"];

        // يمكنك توجيه المستخدم إلى الصفحة التي يجدها مناسبة بعد تسجيل الدخول
        header("Location: index.php");
        exit();
    } else {
        // رسالة خطأ عند بيانات الدخول غير الصحيحة
        $error_message = "اسم المستخدم أو كلمة المرور غير صحيحة.";
    }
}

// إغلاق اتصال قاعدة البيانات
$con->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>

<?php
// عرض رسالة الخطأ إذا كانت موجودة
if (isset($error_message)) {
    echo "<p>$error_message</p>";
}
?>

<!-- نموذج تسجيل الدخول -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="uid">uid:</label>
    <input type="text" id="uid" name="uid" required>
    <br>
    <input type="submit" value="تسجيل الدخول">
</form>

</body>
</html>

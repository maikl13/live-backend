<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIVE</title>
    <!-- تضمين ملفات SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<script>
    window.onload = function() {
        showSuccessMessage();
    };

    function showSuccessMessage() {
        // استخدام SweetAlert2 لعرض رسالة نجاح منبثقة
        Swal.fire({
            icon: 'success',
            title: 'Congratulations',
            text: 'The process was completed successfully.',
            confirmButtonText: 'OK'
          }).then((result) => {
            // توجيه المستخدم إلى صفحة أخرى عند النقر على زر "حسناً"
            if (result.isConfirmed) {
                window.location.href = 'index.php'; // استبدل 'الصفحة-الأخرى.html' بالعنوان URL الصحيح
            }
        });
    }
</script>
</body>
</html>

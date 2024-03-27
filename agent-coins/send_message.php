<?php
// send_message.php
require "config/dbcon.php";

session_start();
$message = $_POST['message'];
$sender_id = $_SESSION['auth_useragent']['agent_id'];
$receiver_id = $_SESSION['auth_useragent']['agent_id'];; // يمكنك تغييرها حسب احتياجاتك

if (!empty($message)) {
    // استعلام للحصول على معلومات العضو (اسم المستخدم ورابط الصورة والرتبة)
    $user_info_query = "SELECT name, image, rank FROM agent_coins WHERE id = '$sender_id'";
    $user_info_result = $con->query($user_info_query);
    $user_info = $user_info_result->fetch_assoc();

    $username = $user_info['name'];
    $image_url = $user_info['image'];
    $rank = $user_info['rank'];

    // استعلام لإدراج الرسالة في قاعدة البيانات
    $sql = "INSERT INTO agents_chatboxadmin (sender_id, receiver_id, message, name, image, rank) 
            VALUES ('$sender_id', '$receiver_id', '$message', '$username', '$image_url', '$rank')";
    $con->query($sql);
}
?>

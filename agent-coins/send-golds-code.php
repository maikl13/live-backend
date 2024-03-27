<?php
session_start();
include('config/dbcon.php');
include('authentication.php');
include('logincode.php');
include('authentication.php');

if(isset($_SESSION['auth_agentcoins']))
{
  echo $_SESSION['auth_useragent']['agent_id']; 
}


$auth_agentcoins = $_SESSION['auth_agentcoins'];

if(isset($_POST['sendGold2']))
{
    $auth_useragent = $_SESSION['auth_useragent'];
    $user_id = $_POST['user_id'];
    $user_uid = $_POST['user_uid'];
    $full_name = $_POST['full_name'];
    $short_digital_id = $_POST['short_digital_id'];
    $gold = $_POST['gold'];

    // الرقم المطلوب
    $desired_amount = $gold; // يمكنك تغيير هذه القيمة حسب احتياجاتك


   $auth_useragent = $_SESSION['auth_useragent']['agent_id'];
     $query = "SELECT credit FROM agent_coins WHERE id = '$auth_useragent';
     
     INSERT INTO agent_coins_transactions (agent_id,user_id,user_fullname,short_digital_id,golds) VALUE ('$auth_useragent','$user_uid','$full_name','$short_digital_id','$gold') ";
   $query_run = mysqli_multi_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = 'Success';
        $_SESSION['status_code'] = 'success';
        header('Location: transactions.php');
}
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header('Location: transactions.php');

    }

}





if(isset($_POST['sendGold']))
{
    $auth_useragent = $_SESSION['auth_useragent'];
    $user_id = $_POST['user_id'];
    $id = $_POST['id'];
    $user_uid = $_POST['user_uid'];
    $full_name = $_POST['full_name'];
    $short_digital_id = $_POST['short_digital_id'];
    $notes = $_POST['notes'];
    $gold = $_POST['gold'];

// الرقم المطلوب
$desired_amount = $gold; // يمكنك تغيير هذه القيمة حسب احتياجاتك
$randomNumberinv = mt_rand(100000, 999999); // توليد رقم عشوائي من 6 أرقام بداية من رقم 1


// الاستعلام لجلب الرصيد من المحفظة
$auth_useragent = $_SESSION['auth_useragent']['agent_id'];
$query = "SELECT credit FROM agent_coins WHERE id = '$auth_useragent'";

$result = $con->query($query);

// التحقق من نتائج الاستعلام
if ($result->num_rows > 0) {
    // استخراج الرصيد من نتيجة الاستعلام
    $row = $result->fetch_assoc();
    $current_balance = $row['credit'];

    // التحقق من ما إذا كان الرصيد كافٍ أو أقل من المبلغ المطلوب
    if ($current_balance !== null && $current_balance >= $desired_amount) 
    {
        $auth_useragent = $_SESSION['auth_useragent']['agent_id'];
        $agent_namee = $_SESSION['auth_useragent']['agent_name'];
        $query2 = "UPDATE users SET gold=gold+'$gold' WHERE ID='$user_id';
   
        UPDATE agent_coins SET credit=credit-'$gold' WHERE ID='$auth_useragent';
        
        INSERT INTO agent_coins_transactions (id,order_id,agent_id,agent_name,user_id,user_fullname,short_digital_id,golds,notes,datetime) VALUE ('$id','$randomNumberinv','$auth_useragent','$agent_namee','$user_uid','$full_name','$short_digital_id','$gold','$notes',NOW()) ";
        $query_run = mysqli_multi_query($con, $query2);

      $_SESSION['status'] = 'Success';
      $_SESSION['status_code'] = 'success';
      header("Location: transaction-view.php?transaction_id=".$randomNumberinv);
      exit();


    }
     else 
    {
        $_SESSION['status'] = 'Your Credits is not enough';
        $_SESSION['status_code'] = 'error';
        header('Location: transactions.php');
    }
} 
else 
{
    // لم يتم العثور على المحفظة
    echo "المحفظة غير موجودة.";
}

}
// إغلاق الاتصال بقاعدة البيانات





//////BACKUP
if(isset($_POST['sendGold22']))
{
    $auth_useragent = $_SESSION['auth_useragent'];
    $user_id = $_POST['user_id'];
    $user_uid = $_POST['user_uid'];
    $full_name = $_POST['full_name'];
    $short_digital_id = $_POST['short_digital_id'];
    $gold = $_POST['gold'];

    // الرقم المطلوب
    $desired_wallet_number = $gold;


   // $query = "UPDATE users SET gold=gold+".$gold." WHERE id='$user_id' ";
   $auth_useragent = $_SESSION['auth_useragent']['agent_id'];
     $query = "UPDATE users SET gold=gold+'$gold' WHERE ID='$user_id';

     UPDATE agent_coins SET credit=credit-'$gold' WHERE ID='$auth_useragent';
     
     INSERT INTO agent_coins_transactions (agent_id,user_id,user_fullname,short_digital_id,golds) VALUE ('$auth_useragent','$user_uid','$full_name','$short_digital_id','$gold') ";
   $query_run = mysqli_multi_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Settings Edit Successfully";
        header("Location: transactions.php");
    }
    else
    {
        $_SESSION['status'] = "Settings Edit Failed";
        header("Location: transactions.php");

    }

}





?>
<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['login_btn']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $id = $_POST['id'];

      $log_query = "SELECT * FROM agent_coins WHERE email='$email' AND password='$password' LIMIT 1";
   
    $log_query_run = mysqli_query($con, $log_query);

    if(mysqli_num_rows($log_query_run) > 0)
    {
        foreach($log_query_run as $row){
            $agent_id = $row['id'];
            $agent_email = $row['email'];
            $agent_name = $row['name'];
            $agent_phone = $row['phone'];
            $agent_image = $row['image'];
            $agent_credit = $row['credit'];
            $role_as = $row['role_as'];
        }

        $_SESSION['auth_agentcoins'] = "$role_as"; 
        $_SESSION['auth_useragent'] = [
            'agent_id'=>$agent_id,
            'agent_email'=>$agent_email,
            'agent_name'=>$agent_name,
            'agent_phone'=>$agent_phone,
            'agent_image'=>$agent_image,
            'agent_credit'=>$agent_credit
        ];

        $_SESSION['status'] = "Login Sucsess.";
        header("Location: index.php");    

    }
    else
    {
        $_SESSION['status'] = "Invaild Email Or Password.";
        header("Location: login.php");    
    }
}
else
{
    $_SESSION['status'] = "Invaild Email Or Password.";
    header("Location: login.php");
}

?>
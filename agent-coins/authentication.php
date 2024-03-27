<?php
if(!isset($_SESSION['auth_agentcoins']))
{
    $_SESSION['auth_status'] = "Login to Access Agent Coins Dashboard";
    header("Location: login.php");  
    exit(0); 
}
else
{
    if($_SESSION['auth_agentcoins'] == "1")
    {

    }
    else
    {
        $_SESSION['status'] = "Your Account is Banned";
        header("Location: ban.php");  
    
    }
}
?>

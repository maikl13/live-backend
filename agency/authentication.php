<?php

if(!isset($_SESSION['uid']))
{
    $_SESSION['auth_status'] = "Login to Access Dashboard";
    header("Location: login.php");  
    exit(0); 
}


?>

<?php
session_start();
include('../config/dbcon.php');
include('../authentication.php');


//delete themes user
if(isset($_POST['Deletethemesuserbtn']))
{
    $user_id = $_POST['delete_id'];

    $query = "DELETE FROM users_bought_themes WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Theme User Delete Done";
    header("Location: ../themes-history.php");
}
else
{
    $_SESSION['status'] = "Theme User Delete Failed";
    header("Location: ../themes-history.php");

}
}


?>
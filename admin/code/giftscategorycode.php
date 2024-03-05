<?php
session_start();
include('../config/dbcon.php');
include('../authentication.php');



if(isset($_POST['updatecategoryGift']))
{
    $user_id = $_POST['user_id'];
    $title = $_POST['title'];

    $query = "UPDATE sections_of_gifts SET title='$title' WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Gift Category Edited";
        header("Location: ../gift-category.php");
    }
    else
    {
        $_SESSION['status'] = "Gift Category Failed";
        header("Location: ../gift-category.php");

    }

}


?>
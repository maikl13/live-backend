<?php
session_start();
include('../config/dbcon.php');
include('../authentication.php');



if(isset($_POST['updatecategoryTheme']))
{
    $themecategory_id = $_POST['themecategory_id'];
    $title = $_POST['title'];

    $query = "UPDATE categories_of_themes SET title='$title' WHERE id='$themecategory_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Theme Category Edited";
        header("Location: ../themes-category.php");
    }
    else
    {
        $_SESSION['status'] = "Theme Category Failed";
        header("Location: ../themes-category.php");

    }

}

if(isset($_POST['DeleteThemecategorybtn']))
{
    $user_id = $_POST['delete_id'];

    $query = "DELETE FROM categories_of_themes WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Theme Category Delete Done";
    header("Location: ../themes-category.php");
}
else
{
    $_SESSION['status'] = "Theme Category Delete Failed";
    header("Location: ../themes-category.php");

}
}



?>
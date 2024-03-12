<?php
session_start();
include('config/dbcon.php');

if(isset($_POST['updateCategoryID']))
{
    $specialidcategory = $_POST['specialidcategory'];
    $title = $_POST['title'];

    $query = "UPDATE special_ids_sections SET title='$title' WHERE id='$specialidcategory'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = 'success';
        $_SESSION['status_code'] = 'success';
        header("Location: special_ids_sections.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header("Location: special_ids_sections.php");

    }

}


if(isset($_POST['updateSubCategoryID']))
{
    $specialidcategory = $_POST['specialidsubcategory'];
    $title = $_POST['title'];
    $price = $_POST['price'];

    $query = "UPDATE special_ids_sub_sections SET title='$title', price='$price' WHERE id='$specialidcategory'";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = 'success';
        $_SESSION['status_code'] = 'success';
        header("Location: special_ids_sub_sections.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header("Location: special_ids_sub_sections.php");

    }

}
?>
<?php
session_start();
include('config/dbcon.php');
include('authentication.php');



//ADD hashtags
if(isset($_POST['addhashtags']))
{
    $title = $_POST['title'];

    $checkemail = "SELECT title FROM hashtags WHERE title='$title' ";
    $checkemail_run = mysqli_query($con, $checkemail);

    if(mysqli_num_rows($checkemail_run) > 0)
    {
        //taken ex
        $_SESSION['status'] = "Name hashtag is Already Taken.";
        header("Location: ../hashtags.php");

    }
    else
    {
        //ok = record not found
        $admin_query = "INSERT INTO hashtags (title) VALUES ('$title')";
        $admin_query_run = mysqli_query($con, $admin_query);
            
        if($admin_query_run)
        {
            $_SESSION['status'] = "Hashtags Added";
            header("Location: ../hashtags.php");
        }
        else
        {
            $_SESSION['status'] = "Hashtags Added Failed";
            header("Location: ../hashtags.php");
    
        }
    }

    }


if(isset($_POST['updateHashtags']))
{
    $user_id = $_POST['user_id'];
    $title = $_POST['title'];

    $query = "UPDATE hashtags SET title='$title' WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Hashtags Edited";
        header("Location: ../hashtags.php");
    }
    else
    {
        $_SESSION['status'] = "Hashtags EDIT Failed";
        header("Location: ../hashtags.php");

    }

}

if(isset($_POST['Deletehashtagsbtn']))
{
    $user_id = $_POST['delete_id'];

    $query = "DELETE FROM hashtags WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "hashtags Delete Done";
    header("Location: ../hashtags.php");
}
else
{
    $_SESSION['status'] = "hashtags Delete Failed";
    header("Location: ../hashtags.php");

}
}

?>
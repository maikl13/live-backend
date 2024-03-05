<?php
session_start();
include('../config/dbcon.php');
include('../authentication.php');



//Edit Post


if(isset($_POST['updatePost']))
{
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $admintype = $_POST['admintype'];
    $password = $_POST['password'];

    $query = "UPDATE admins SET name='$name', phone='$phone', email='$email', admintype='$admintype', password='$password' WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        $_SESSION['status'] = "Post Edited";
        header("Location: ../posts.php");
    }
    else
    {
        $_SESSION['status'] = "POST EDIT Failed";
        header("Location: ../posts.php");

    }

}

if(isset($_POST['DeletePostbtn']))
{
    $user_id = $_POST['delete_id'];

    $query = "DELETE FROM posts WHERE id = '$user_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Post Delete Done";
    header("Location: ../posts.php");
}
else
{
    $_SESSION['status'] = "Post Delete Failed";
    header("Location: ../posts.php");

}
}

?>


<?php

    // sql to delete a record
    $sql = "DELETE FROM posts WHERE id='".$_GET['id_post']."' ";

    if ($con->query($sql) === TRUE) {
       header("Location: ../posts.php");
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();

?>
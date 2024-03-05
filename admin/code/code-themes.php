<?php
session_start();
include('../config/dbcon.php');
include('../authentication.php');


//ADD Themes
if(isset($_POST['addAdmin']))
{
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $admintype = $_POST['admintype'];
    $password = $_POST['password'];

    $checkemail = "SELECT email FROM admins WHERE email='$email' ";
    $checkemail_run = mysqli_query($con, $checkemail);

    if(mysqli_num_rows($checkemail_run) > 0)
    {
        //taken ex
        $_SESSION['status'] = "Email is Already Taken.";
        header("Location: ../admins.php");

    }
    else
    {
        //ok = record not found
        $admin_query = "INSERT INTO admins (name,phone,email,admintype,password) VALUES ('$name','$phone','$email','$admintype','$password')";
        $admin_query_run = mysqli_query($con, $admin_query);
            
        if($admin_query_run)
        {
            $_SESSION['status'] = "Admin Added";
            header("Location: ../admins.php");
        }
        else
        {
            $_SESSION['status'] = "Admin Added Failed";
            header("Location: ../admins.php");
    
        }
    }

    }


if(isset($_POST['updateAdmin']))
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
        $_SESSION['status'] = "Admin Edited";
        header("Location: ../admins.php");
    }
    else
    {
        $_SESSION['status'] = "Admin EDIT Failed";
        header("Location: ../admins.php");

    }

}

if(isset($_POST['DeleteThemebtn']))
{
    $user_id = $_POST['delete_id'];

    $query = "DELETE FROM themes WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Theme Delete Done";
    header("Location: ../themes.php");
}
else
{
    $_SESSION['status'] = "Theme Delete Failed";
    header("Location: ../themes.php");

}
}



?>

<?php

    // sql to delete a record
    $sql = "DELETE FROM themes WHERE id='".$_GET['id_theme']."' ";

    if ($con->query($sql) === TRUE) {
       header("Location: ../themes.php");
    } else {
        echo "Error deleting record: " . $con->error;
    }

    $con->close();

?>
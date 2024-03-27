<?php
session_start();
include('config/dbcon.php');
include('authentication.php');


if(isset($_POST['logout_btn']))
{
   // session_destroy();
    unset($_SESSION['auth_agentcoins']);
    unset($_SESSION['auth_useragent']);

    $_SESSION['status'] = "Logged out Sucsess";
    header("Location: login.php"); 
    exit(0);
}

//ADD ADMIN
    if (isset($_POST['addAdmin'])) {


        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $image = $_FILES['image']['name'];

        //Rename this image
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $filename = time().'.'.$image_extension;
    
        $checkemail = "SELECT email FROM admins WHERE email='$email' ";
        $checkemail_run = mysqli_query($con, $checkemail);

        $checkname = "SELECT name FROM admins WHERE name='$name' ";
        $checkname_run = mysqli_query($con, $checkname);

        $checkphone = "SELECT phone FROM admins WHERE phone='$phone' ";
        $checkphone_run = mysqli_query($con, $checkphone);

    
        if(mysqli_num_rows($checkemail_run) > 0)
        {
            //taken email
            $_SESSION['status'] = "Email is Already Taken.";
            $_SESSION['status_code'] = 'error';
            header("Location: admins.php");
    
        }
        else
        if(mysqli_num_rows($checkname_run) > 0)
        {
            //taken name
            $_SESSION['status'] = "Name is Already Taken.";
            $_SESSION['status_code'] = 'error';
            header("Location: admins.php");
    
        }
        else
        if(mysqli_num_rows($checkphone_run) > 0)
        {
            //taken Phone Number
            $_SESSION['status'] = "Phone Number is Already Taken.";
            $_SESSION['status_code'] = 'error';
            header("Location: admins.php");
    
        }
        else
        {
        
            //ok = record not found
    
    
            $query = "INSERT INTO admins (name,phone,email,password,image) VALUE ('$name','$phone','$email','$password','$filename')";
            $query_run = mysqli_query($con, $query);
            if($query_run)
             {
            move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$filename);
            $_SESSION['status'] = 'Success';
            $_SESSION['status_code'] = 'success';
            header('Location: admins.php');
        }
        else {
           $_SESSION['status'] = 'ERROR';
           $_SESSION['status_code'] = 'error';
           header('Location: admins.php');
        }
     }
    }



if(isset($_POST['updateAdmin']))
{
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $old_filename = $_POST['old_image'];
    $image = $_FILES['image']['name'];

    $update_filename = "";
    if($image != NULL)
    {
            //Rename this image
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_extension;

    $update_filename = $filename;
    }
    else
    {
        $update_filename = $old_filename;
    }


    $query = "UPDATE admins SET name='$name', phone='$phone', email='$email',  password='$password', image='$update_filename' WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);

    if($query_run)
    {
        if($image != NULL){
            if(file_exists('../images/'.$old_filename)){
                unlink("../images/'.$old_filename");

            }
            move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$update_filename);
     }
     $_SESSION['status'] = 'Success';
     $_SESSION['status_code'] = 'success';
     header("Location: admins.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header("Location: admins.php");

    }

}



if(isset($_POST['DeleteAdminbtn']))
{
    $user_id = $_POST['delete_id'];

    $query = "DELETE FROM admins WHERE id='$user_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Admin Delete Done";
    header("Location: admins.php");
}
else
{
    $_SESSION['status'] = "Admin Delete Failed";
    header("Location: admins.php");

}
}

?>
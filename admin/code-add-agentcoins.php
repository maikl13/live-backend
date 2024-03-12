<?php
session_start();
include('config/dbcon.php');
include('authentication.php');


//ADD ADMIN
if (isset($_POST['addAgentcoins'])) {


    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $credit = $_POST['credit'];
    $image = $_FILES['image']['name'];
    $created_at = $_FILES['created_at'];

    //Rename this image
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_extension;

    $checkemail = "SELECT email FROM agent_coins WHERE email='$email' ";
    $checkemail_run = mysqli_query($con, $checkemail);

    $checkname = "SELECT name FROM agent_coins WHERE name='$name' ";
    $checkname_run = mysqli_query($con, $checkname);


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
    {
    
        //ok = record not found


        $query = "INSERT INTO agent_coins (name, email, password, credit, image, created_at) VALUES ('$name', '$email', '$password', '$credit', '$filename', NOW())";
      $query_run = mysqli_query($con, $query);
        if($query_run)
         {
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$filename);
        $_SESSION['status'] = 'Success';
        $_SESSION['status_code'] = 'success';
        header('Location: agent-coins.php');
    }
    else {
       $_SESSION['status'] = 'ERROR';
       $_SESSION['status_code'] = 'error';
       header('Location: agent-coins.php');
    }
 }
}


if(isset($_POST['updateAgent']))
{
    $agent_id = $_POST['agent_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $credit = $_POST['credit'];
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

    $query = "UPDATE agent_coins SET name='$name', email='$email', password='$password', credit='$credit', image='$update_filename' WHERE id='$agent_id' ";
    $query_run = mysqli_query($con, $query);


    if($query_run)
    {
        if($image != NULL){
            if(file_exists('../images/'.$old_filename))
            {
                unlink("../images/'.$old_filename");

            }
            move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$update_filename);
     }
       $_SESSION['status'] = 'Success';
       $_SESSION['status_code'] = 'success';
        header("Location: agent-coins.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header("Location: agent-coins.php");

    }

}





//Delete Agency
if(isset($_POST['DeleteAgentbtn']))
{
    $agent_id = $_POST['delete_id'];

    $query = "DELETE FROM agent_coins WHERE id='$agent_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Agent Delete Done";
    header("Location: agent-coins.php");
}
else
{
    $_SESSION['status'] = "Agent Delete Failed";
    header("Location: agent-coins.php");

}
}


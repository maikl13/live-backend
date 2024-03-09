<?php
session_start();
include('config/dbcon.php');
include('authentication.php');


     if(isset($_POST['addagency']))
{
    $name = $_POST['name'];
    $bio = $_POST['bio'];
    $owner_uid = $_POST['owner_uid'];
    $image = $_FILES['image']['name'];
    $flag = $_FILES['flag']['name'];

    
            //Rename this image
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_extension;
    //flag
    $flag_extension = pathinfo($flag, PATHINFO_EXTENSION);
    $flagfilename = time().'.'.$flag_extension;


    $query = "INSERT INTO agency (name,bio,owner_uid,flag,image) VALUE ('$name','$bio','$owner_uid','$flagfilename','$filename')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
{
    move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$filename);
}
    move_uploaded_file($_FILES['flag']['tmp_name'], '../images/'.$flagfilename);
    $_SESSION['status'] = 'Success';
    $_SESSION['status_code'] = 'success';
    header("Location: agency.php");
}
else
{
    $_SESSION['status'] = 'ERROR';
    $_SESSION['status_code'] = 'error';
    header("Location: agency.php");

}

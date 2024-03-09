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

//Update Agency
if(isset($_POST['updateAgency']))
{
    $agency_id = $_POST['agency_id'];
    $name = $_POST['name'];
    $bio = $_POST['bio'];
    $old_filename = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $old_filenameicon = $_POST['old_icon'];
    $icon = $_FILES['icon']['name'];

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
    $update_filenameicon = "";
    if($icon != NULL)
    {
            //Rename this image
    $icon_extension = pathinfo($icon, PATHINFO_EXTENSION);
    $filenameicon = time().'.'.$icon_extension;

    $update_filenameicon = $filenameicon;
    }
    else
    {
        $update_filenameicon = $old_filenameicon;
    }


    $query = "UPDATE agency SET  name='$name', value='$value', section='$section', currency_type='$currency_type',level='$level', image='$update_filename', icon='$update_filenameicon' WHERE id='$gift_id' ";
    $query_run = mysqli_query($con, $query);


    if($query_run)
    {
        if($image != NULL){
            if(file_exists('../images/'.$old_filename)){
                unlink("../images/'.$old_filename");

            }

            move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$update_filename);
     }
     if($icon != NULL){
        if(file_exists('../images/'.$old_filenameicon)){
            unlink("../images/'.$old_filenameicon");

        }

        move_uploaded_file($_FILES['icon']['tmp_name'], '../images/'.$update_filenameicon);
    }
     $_SESSION['status'] = 'Success';
     $_SESSION['status_code'] = 'success';
     header("Location: gifts.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
          header("Location: gifts.php");

    }

}


//Delete Agency
if(isset($_POST['DeleteAgencybtn']))
{
    $user_id = $_POST['delete_id'];

    $query = "DELETE FROM agency WHERE id='$agency_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Agency Delete Done";
    header("Location: agency.php");
}
else
{
    $_SESSION['status'] = "Agency Delete Failed";
    header("Location: agency.php");

}
}


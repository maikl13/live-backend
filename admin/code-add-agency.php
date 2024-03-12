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
    $owner_uid = $_POST['owner_uid'];
    $old_filename = $_POST['old_image'];
    $image = $_FILES['image']['name'];
    $old_filenameflag = $_POST['old_flag'];
    $flag = $_FILES['flag']['name'];

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
    $update_filenameflag = "";
    if($flag != NULL)
    {
            //Rename this image
    $flag_extension = pathinfo($flag, PATHINFO_EXTENSION);
    $filenameflag = time().'.'.$flag_extension;

    $update_filenameflag = $filenameflag;
    }
    else
    {
        $update_filenameflag = $old_filenameflag;
    }


    $query = "UPDATE agency SET  name='$name', bio='$bio', owner_uid='$owner_uid', image='$update_filename', flag='$update_filenameflag' WHERE id='$agency_id' ";
    $query_run = mysqli_query($con, $query);


    if($query_run)
    {
        if($image != NULL){
            if(file_exists('../images/'.$old_filename)){
                unlink("../images/'.$old_filename");

            }

            move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$update_filename);
     }
     if($flag != NULL){
        if(file_exists('../images/'.$old_filenameflag)){
            unlink("../images/'.$old_filenameflag");

        }

        move_uploaded_file($_FILES['flag']['tmp_name'], '../images/'.$update_filenameflag);
    }
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


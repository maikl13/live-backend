<?php
session_start();
include('config/dbcon.php');
include('authentication.php');


     if(isset($_POST['addTheme']))
{
    $category = $_POST['category'];
    $title = $_POST['title'];
    $golds = $_POST['golds'];
    $days = $_POST['days'];
    $image = $_FILES['image']['name'];

    
            //Rename this image
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_extension;


    $query = "INSERT INTO themes (category,title,golds,days,image) VALUE ('$category','$title','$golds','$days','$filename')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
{
    move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$filename);
    $_SESSION['status'] = 'Success';
    $_SESSION['status_code'] = 'success';
    header("Location: themes.php");
}
else
{
    $_SESSION['status'] = 'ERROR';
    $_SESSION['status_code'] = 'error';
    header("Location: themes.php");

}

 }
 



if(isset($_POST['updateTheme']))
{
    $theme_id = $_POST['theme_id'];
    $category = $_POST['category'];
    $title = $_POST['title'];
    $golds = $_POST['golds'];
    $days = $_POST['days'];
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

    $query = "UPDATE themes SET category='$category', title='$title', golds='$golds', days='$days', image='$update_filename' WHERE id='$theme_id' ";
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
        header("Location: themes.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header("Location: themes.php");

    }

}




if(isset($_POST['DeleteThemebtn']))
{
    $theme_id = $_POST['delete_id'];

    $query = "DELETE FROM themes WHERE id='$theme_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Theme Delete Done";
    header("Location: themes.php");
}
else
{
    $_SESSION['status'] = "Theme Delete Failed";
    header("Location: themes.php");

}
}

?>
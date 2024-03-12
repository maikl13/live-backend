<?php
session_start();
include('config/dbcon.php');
include('authentication.php');



//ADD Hats
if(isset($_POST['addBanner']))
{
    $image = $_FILES['image']['name'];
    $web_view_link = $_POST['web_view_link'];

    
            //Rename this image
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_extension;


    $query = "INSERT INTO featured_moments_ads (image,web_view_link) VALUE ('$filename','$web_view_link')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
{
    move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$filename);
    $_SESSION['status'] = 'Success';
    $_SESSION['status_code'] = 'success';
    header("Location: moments-banners.php");
}
else
{
    $_SESSION['status'] = 'ERROR';
    $_SESSION['status_code'] = 'error';
    header("Location: moments-banners.php");

}

 }



if(isset($_POST['updateAdmin']))
{
    $banner_id = $_POST['banner_id'];
    $web_view_link = $_POST['web_view_link'];
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


    $query = "UPDATE rooms_page_ads SET web_view_link='$web_view_link', image='$update_filename' WHERE id='$banner_id' ";
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
     header("Location: home-banners.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header("Location: home-banners.php");

    }

}



if(isset($_POST['DeleteBannerbtn']))
{
    $banner_id = $_POST['delete_id'];

    $query = "DELETE FROM featured_moments_ads WHERE id='$banner_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Banner Delete Done";
    header("Location: moments-banners.php");
}
else
{
    $_SESSION['status'] = "Banner Delete Failed";
    header("Location: moments-banners.php");

}
}

?>
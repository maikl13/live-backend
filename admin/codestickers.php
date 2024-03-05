<?php
session_start();
include('config/dbcon.php');
include('authentication.php');


if(isset($_POST['addSticker']))
{
    $title = $_POST['title'];
    $section = $_POST['section'];
    $image = $_FILES['image']['name'];

    
            //Rename this image
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_extension;


    $query = "INSERT INTO stickers (title,section,image) VALUE ('$title','$section','$filename')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
{
    move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$filename);
    $_SESSION['status'] = 'Success';
    $_SESSION['status_code'] = 'success';
    header("Location: stickers.php");
}
else
{
    $_SESSION['status'] = 'ERROR';
    $_SESSION['status_code'] = 'error';
    header("Location: stickers.php");

}

 }


 
 
 if(isset($_POST['updateSticker']))
 {
     $sticker_id = $_POST['sticker_id'];
     $title = $_POST['title'];
     $section = $_POST['section'];
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
 
     $query = "UPDATE stickers SET title='$title', section='$section', image='$update_filename' WHERE id='$sticker_id' ";
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
         header("Location: stickers.php");
     }
     else
     {
         $_SESSION['status'] = 'ERROR';
         $_SESSION['status_code'] = 'error';
         header("Location: stickers.php");
 
     }
 
 }






if(isset($_POST['DeleteStickerbtn']))
{
    $sticker_id = $_POST['delete_id'];

    $query = "DELETE FROM stickers WHERE id='$sticker_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Sticker Delete Done";
    header("Location: stickers.php");
}
else
{
    $_SESSION['status'] = "Sticker Delete Failed";
    header("Location: stickers.php");

}
}

?>
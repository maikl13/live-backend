<?php
session_start();
include('config/dbcon.php');
include('authentication.php');


//ADD Hats
    if(isset($_POST['addhat']))
    {
        $title = $_POST['title'];
        $days = $_POST['days'];
        $golds = $_POST['golds'];
        $only_premium = $_POST['only_premium'];
        $image = $_FILES['image']['name'];
    
        
                //Rename this image
        $image_extension = pathinfo($image, PATHINFO_EXTENSION);
        $filename = time().'.'.$image_extension;
    
    
        $query = "INSERT INTO hats (title,days,golds,only_premium,image) VALUE ('$title','$days','$golds','$only_premium','$filename')";
        $query_run = mysqli_query($con, $query);
    
        if($query_run)
    {
        move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$filename);
        $_SESSION['status'] = 'Success';
        $_SESSION['status_code'] = 'success';
        header("Location: hats.php");
    }
    else
    {
        $_SESSION['status'] = 'ERROR';
        $_SESSION['status_code'] = 'error';
        header("Location: hats.php");
    
    }
    
     }
    
     if(isset($_POST['updateHat']))
     {
         $hat_id = $_POST['hat_id'];
         $title = $_POST['title'];
         $days = $_POST['days'];
         $golds = $_POST['golds'];
         $only_premium = $_POST['only_premium'];
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
     
         $query = "UPDATE hats SET title='$title', days='$days', golds='$golds', only_premium='$only_premium', image='$update_filename' WHERE id='$hat_id' ";
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
             header("Location: hats.php");
         }
         else
         {
             $_SESSION['status'] = 'ERROR';
             $_SESSION['status_code'] = 'error';
             header("Location: hats.php");
     
         }
     
     }



if(isset($_POST['DeleteHatbtn']))
{
    $hat_id = $_POST['delete_id'];

    $query = "DELETE FROM hats WHERE id='$hat_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Hat Delete Done";
    header("Location: hats.php");
}
else
{
    $_SESSION['status'] = "Hat Delete Failed";
    header("Location: hats.php");

}
}




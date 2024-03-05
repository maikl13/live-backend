<?php
session_start();
include('config/dbcon.php');
include('authentication.php');


     if(isset($_POST['addGift']))
{
    $title = $_POST['title'];
    $value = $_POST['value'];
    $section = $_POST['section'];
    $currency_type = $_POST['currency_type'];
    $level = $_POST['level'];
    $image = $_FILES['image']['name'];
    $icon = $_FILES['icon']['name'];

    
            //Rename this image
    $image_extension = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time().'.'.$image_extension;
    //icon
    $icon_extension = pathinfo($icon, PATHINFO_EXTENSION);
    $iconfilename = time().'.'.$icon_extension;


    $query = "INSERT INTO gifts (title,value,section,currency_type,level,icon,image) VALUE ('$title','$value','$section','$currency_type','$level','$iconfilename','$filename')";
    $query_run = mysqli_query($con, $query);

    if($query_run)
{
    move_uploaded_file($_FILES['image']['tmp_name'], '../images/'.$filename);
}
    move_uploaded_file($_FILES['icon']['tmp_name'], '../images/'.$iconfilename);
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

 
 



if(isset($_POST['updateGift']))
{
    $gift_id = $_POST['gift_id'];
    $title = $_POST['title'];
    $value = $_POST['value'];
    $section = $_POST['section'];
    $currency_type = $_POST['currency_type'];
    $level = $_POST['level'];
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


    $query = "UPDATE gifts SET  title='$title', value='$value', section='$section', currency_type='$currency_type',level='$level', image='$update_filename', icon='$update_filenameicon' WHERE id='$gift_id' ";
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




if(isset($_POST['DeleteGiftbtn']))
{
    $gift_id = $_POST['delete_id'];

    $query = "DELETE FROM gifts WHERE id='$gift_id' ";
    $query_run = mysqli_query($con, $query);


if($query_run)
{
    $_SESSION['status'] = "Gift Delete Done";
    header("Location: gifts.php");
}
else
{
    $_SESSION['status'] = "Gift Delete Failed";
    header("Location: gifts.php");

}
}

?>
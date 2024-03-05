<?php
include "config.php";

$image64 =$_POST['image64'];
$image_name =$_POST['image_name'];
$image=base64_decode($image64);
file_put_contents('images/'.$image_name,$image);

?>
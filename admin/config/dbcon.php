
<?php

$host = "92.205.144.215";
$username = "yalla_chat";
$password = "NUeSyRHLj?dD";
$database = "yalla_chat";

//Connection
$con = mysqli_connect("$host","$username","$password","$database");

// Check Connection
if(!$con)
{
    header("Location: ../errors/db.php");
    die();
   // die(mysqli_connect_errno($con));
}
//else{
  //  echo "Database Connected / Welcome Eslam";
//}
?>
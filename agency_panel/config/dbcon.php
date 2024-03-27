
<?php


$username = "tictic";
$password = "tic@4321";
$database = "yalla_chat";

//Connection
$conn = mysqli_connect("localhost","$username","$password","$database");


// Check Connection
if(!$conn)
{
    header("Location: ../errors/db.php");
    die();
   // die(mysqli_connect_errno($con));
}
//else{
  //  echo "Database Connected / Welcome Eslam";
//}

// Set charset
$conn->set_charset('utf8mb4');

?>
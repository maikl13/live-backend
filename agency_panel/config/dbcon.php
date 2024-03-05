

<?php



    // Assuming you have a MySQL database connection
    $dbHost = '92.205.144.215';
    $dbUser = 'yalla_chat';
    $dbPass = 'NUeSyRHLj?dD';
    $dbName = 'yalla_chat';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    // Check the database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

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

?>
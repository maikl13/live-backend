<?php
// get_messages.php
require "config/dbcon.php";

session_start();
$receiver_id = $_SESSION['auth_useragent']['agent_id'];

$sql = "SELECT agents_chatboxadmin.message, agents_chatboxadmin.name, agents_chatboxadmin.image, agents_chatboxadmin.rank 
        FROM agents_chatboxadmin 
        WHERE agents_chatboxadmin.receiver_id = '$receiver_id'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) 
    {
        echo "     <p><img src='" . $row['image'] . "' class='img-circle elevation-2' alt='User Image' style='width: 30px; height: 30px;'>" .
              $row['name'] . " (" . $row['rank'] . "): " . $row['message'] . "</p>";
    }
}
?>

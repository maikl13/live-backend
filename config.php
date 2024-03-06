<?php

	header('Content-type: application/json');
date_default_timezone_set('UTC'); 
//// init main prams /////

ini_set('display_errors', 1);

$mysql_database= "yalla_chat";
$mysql_user= "tictic";
$mysql_password= "tic@4321";
$mysqli = new mysqli("localhost", $mysql_user, $mysql_password, $mysql_database);
$pdo = new PDO("mysql:localhost=$mysql_user;dbname=$mysql_database", $mysql_user, $mysql_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
if (mysqli_connect_errno()) {
    echo "error mysqli";
    exit();
}
///// support arabic text //////

$utf8_enable = "SET character_set_results = 'utf8mb4', character_set_client = 'utf8mb4', character_set_connection = 'utf8mb4', character_set_database = 'utf8mb4', character_set_server = 'utf8mb4' , time_zone = '+00:00';";
$mysqli->query($utf8_enable);

///// helper function //////
function readRowFromSql($code, $one = true)
{
    global $mysqli;
    $result   = $mysqli->query($code);
    $readData = "";
    if ($one) {
        while ($row = $result->fetch_assoc()) {
            return $row;
        }
        return null;
    } else {
        $rows = array();
        while ($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        return $rows;
    }
}

function readRowFromSqlAlana($code, $one = true)
{
    global $mysqli;
    $result   = $mysqli->query($code);
    $readData = "";
    if ($one) {
        while ($row = $result->fetch_assoc()) {
            return $row;
        }
        return null;
    } else {
      

        return $result;
    }
}




function postToSql($code)
{
    global $mysqli;
    $result   = $mysqli->query($code);
 return  $result;
}

function updateSql($code)
{
    global $mysqli;
    $result   = $mysqli->query($code);
 return  $result;
}
function InsertAndGetId($code)
{
     global $mysqli;
 $sql = "$code";

if ($mysqli->query($sql) === TRUE) {
    $last_id = $mysqli->insert_id;
    return  $last_id;
} else {
    return "Error: " . $sql . "<br>" . $mysqli->error;
 
}

}

?>
<?php

$servername = "localhost";
$databasename = "db_level2_opdr1";
$username = "DC";
$password = "admin";

$conn = new mysqli($servername, $username, $password, $databasename);
if($conn->connect_error){
    die("connection failed: " . $conn->connect_error);
}
echo "connected succesfully";
?>
<?php

$servername = "us-cdbr-azure-east-c.cloudapp.net";
$username = "b8d336655a4539";
$password = "d9860c08";
$dbname = "qbnb";
// Create connection
$con = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($con->connect_error) {
     die("Connection failed: " . $con->connect_error);
}


?>

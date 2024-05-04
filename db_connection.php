<?php

$servername = "localhost"; 
$username = "edduser";
$password = "edduserpassword";
$dbname = "elemental_dream_depot";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    echo 'connection establishbest failed';
    die("Connection failed: " . $conn->connect_error);
}
?>

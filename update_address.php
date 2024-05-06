<?php
session_start();


function logout()
{

    $_SESSION = array();


    session_destroy();


    header("location: shopper_login.php");
    exit;
}


if (isset($_GET['logout'])) {
    logout();
}


include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address_id = $_POST["address_id"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zipCode = $_POST["zipCode"];

    $sql_update = "UPDATE shopper_address SET address = '$address', city = '$city', state = '$state', zipCode = '$zipCode' WHERE address_id = $address_id";
    if ($conn->query($sql_update) === TRUE) {

        header("location: manageAddress.php");
        exit;
    } else {
        echo "Error updating address: " . $conn->error;
    }
}

$conn->close();
?>
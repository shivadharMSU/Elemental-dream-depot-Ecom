<?php
session_start();

// Function to log out the user
function logout() {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other desired page
    header("location: shopper_login.php");
    exit;
}

// Check if the logout GET parameter is set
if (isset($_GET['logout'])) {
    logout();
}

// Include database connection
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address_id = $_POST["address_id"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zipCode = $_POST["zipCode"];

    $sql_update = "UPDATE shopper_address SET address = '$address', city = '$city', state = '$state', zipCode = '$zipCode' WHERE address_id = $address_id";
    if ($conn->query($sql_update) === TRUE) {
        // Address updated successfully, redirect to manageAddress.php
        header("location: manageAddress.php");
        exit;
    } else {
        echo "Error updating address: " . $conn->error;
    }
}

$conn->close();
?>

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




if (isset($_GET["address_id"])) {
    $address_id = $_GET["address_id"];
    $sql_fetch_address = "DELETE FROM shopper_address WHERE address_id = $address_id";
    $result_fetch_address = $conn->query($sql_fetch_address);
    header("location: manageAddress.php");
    // if ($result_fetch_address->num_rows > 0) {
    //     $row_address = $result_fetch_address->fetch_assoc();
    //     header("location: manageAddress.php");
    // }
}
$conn->close();
?>

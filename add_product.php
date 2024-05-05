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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection
    include 'db_connection.php';

    // Prepare and bind the insert statement
    $sql = "INSERT INTO product (product_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productName);

    // Set parameters and execute
    $productName = $_POST["productName"];
    $stmt->execute();

    // Close statement
    $stmt->close();

    // Close connection
    $conn->close();

    // Redirect back to the product management page
    header("location: manage_products.php");
    exit;
}
?>

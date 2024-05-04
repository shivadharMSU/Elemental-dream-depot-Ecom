<?php
session_start();

// Include database connection
include 'db_connection.php';

// Check if item_id and shopper_id are provided
if(isset($_POST['item_id']) && isset($_POST['shopper_id'])) {
    // Sanitize inputs
    $item_id = $_POST['item_id'];
    $shopper_id = $_POST['shopper_id'];

    // Prepare and execute DELETE query
    $sql = "DELETE FROM cart WHERE item_id = ? AND shopper_id = ? and is_orderd = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $item_id, $shopper_id);
    $stmt->execute();

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();

// Redirect back to the shopping cart page
header("Location: shoppingCart.php");
exit;
?>

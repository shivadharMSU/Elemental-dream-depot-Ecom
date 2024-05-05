<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Redirect to the login page if not logged in
    header("location: shopper_login.php");
    exit;
}

// Check if all required fields are present
if (isset($_POST['item_id'], $_POST['quantity'])) {
    // Sanitize inputs
    $shopper_id = $_SESSION["shopper_id"];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $product_id = $_POST['product_id'];
    $isOrdered = 0;

    // Include database connection
    include 'db_connection.php';
    
    // Prepare and execute the SQL statement to insert into the cart table
    $sql = "INSERT INTO cart (shopper_id, item_id, quantity,is_orderd) VALUES (?, ?, ?,?)";

    $stmt = $conn->prepare($sql);
   
    $stmt->bind_param("iiii", $shopper_id, $item_id, $quantity,$isOrdered);
   
    
    if ($stmt->execute()) {
       
        // Item successfully added to the cart
        header("location: product.php?product_id=$product_id");
    } else {
        // Error occurred while adding item to cart
        echo "Error: Unable to add item to cart.";
    }

    // Close the database connection
    $conn->close();
} else {
    // Redirect to the product page if required fields are not provided
    header("location: product.php");
    exit;
}
?>

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Redirect to the login page if not logged in
    header("location: shopper_login.php");
    exit;
}

// Include database connection
include 'db_connection.php';

// Get shopper_id from session
$shopper_id = $_SESSION["shopper_id"];

// Get current date
$order_date = date("Y-m-d");

// Get all records from the cart table for the logged-in shopper
$sql_cart = "SELECT * FROM cart WHERE shopper_id = ?";
$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bind_param("i", $shopper_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();

// Insert data into orders table
$sql_insert_order = "INSERT INTO orders (shopper_id, order_date) VALUES (?, ?)";
$stmt_insert_order = $conn->prepare($sql_insert_order);
$stmt_insert_order->bind_param("is", $shopper_id, $order_date);
$stmt_insert_order->execute();

// Get the auto-generated order_id
$order_id = $stmt_insert_order->insert_id;

// Initialize total price
$total_price = 0;
echo 'before loop';
// Insert data into item_order_mapping table and calculate total price
while ($row_cart = $result_cart->fetch_assoc()) {
    echo 'after loop';
    $item_id = $row_cart['item_id'];
    $quantity = $row_cart['quantity'];

    // Get price from item table based on item_id
    $sql_price = "SELECT price FROM item WHERE item_id = ?";
    $stmt_price = $conn->prepare($sql_price);
    $stmt_price->bind_param("i", $item_id);
    $stmt_price->execute();
    $result_price = $stmt_price->get_result();
    $row_price = $result_price->fetch_assoc();
    $price = $row_price['price'];
      
    // Calculate total price
    $total_price += $price * $quantity;
     
    // Insert data into item_order_mapping table
    $sql_insert_mapping = "INSERT INTO item_order_mappping (order_id, item_id, shopper_id, quantity) VALUES (?, ?, ?, ?)";
    
    $stmt_insert_mapping = $conn->prepare($sql_insert_mapping);
    $stmt_insert_mapping->bind_param("iiii", $order_id, $item_id, $shopper_id, $quantity);
    $stmt_insert_mapping->execute();
}

// Update total price in orders table
$sql_update_total_price = "UPDATE orders SET total_price = ? WHERE order_id = ?";
$stmt_update_total_price = $conn->prepare($sql_update_total_price);
$stmt_update_total_price->bind_param("di", $total_price, $order_id);
$stmt_update_total_price->execute();

// Update is_ordered field in cart table
$sql_update_cart = "UPDATE cart SET is_orderd = 1 WHERE shopper_id = ?";
$stmt_update_cart = $conn->prepare($sql_update_cart);
$stmt_update_cart->bind_param("i", $shopper_id);
$stmt_update_cart->execute();

// Close database connection
$conn->close();

// Redirect to index.php
header("location: index.php");
exit;
?>

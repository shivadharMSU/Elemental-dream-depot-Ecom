<?php
session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: shopper_login.php");
    exit;
}


include 'db_connection.php';


$shopper_id = $_SESSION["shopper_id"];
$address_id = $_POST["address_id"];
$payment_method = $_POST["payment_method"];

$order_date = date("Y-m-d");


$sql_cart = "SELECT * FROM cart WHERE shopper_id = ? and is_orderd = 0";
$stmt_cart = $conn->prepare($sql_cart);
$stmt_cart->bind_param("i", $shopper_id);
$stmt_cart->execute();
$result_cart = $stmt_cart->get_result();


$sql_insert_order = "INSERT INTO orders (shopper_id, order_date,address_id, payment_method) VALUES (?, ?, ?, ?)";
$stmt_insert_order = $conn->prepare($sql_insert_order);
$stmt_insert_order->bind_param("isis", $shopper_id, $order_date, $address_id, $payment_method);
$stmt_insert_order->execute();


$order_id = $stmt_insert_order->insert_id;


$total_price = 0;


while ($row_cart = $result_cart->fetch_assoc()) {
   
    $item_id = $row_cart['item_id'];
    $quantity = $row_cart['quantity'];
    $sql_price = "SELECT price FROM item WHERE item_id = ?";
    $stmt_price = $conn->prepare($sql_price);
    $stmt_price->bind_param("i", $item_id);
    $stmt_price->execute();
    $result_price = $stmt_price->get_result();
    $row_price = $result_price->fetch_assoc();
    $price = $row_price['price'];


    $total_price += $price * $quantity;

    $sql_insert_mapping = "INSERT INTO item_order_mappping (order_id, item_id, shopper_id, quantity) VALUES (?, ?, ?, ?)";

    $stmt_insert_mapping = $conn->prepare($sql_insert_mapping);
    $stmt_insert_mapping->bind_param("iiii", $order_id, $item_id, $shopper_id, $quantity);
    $stmt_insert_mapping->execute();
}

$sql_update_total_price = "UPDATE orders SET total_price = ? WHERE order_id = ?";
$stmt_update_total_price = $conn->prepare($sql_update_total_price);
$stmt_update_total_price->bind_param("di", $total_price, $order_id);
$stmt_update_total_price->execute();

$sql_update_cart = "UPDATE cart SET is_orderd = 1 WHERE shopper_id = ?";
$stmt_update_cart = $conn->prepare($sql_update_cart);
$stmt_update_cart->bind_param("i", $shopper_id);
$stmt_update_cart->execute();

$conn->close();


header("location: home.php");
exit;
?>
<?php
session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {

    header("location: shopper_login.php");
    exit;
}

if (isset($_POST['item_id'], $_POST['quantity'])) {

    $shopper_id = $_SESSION["shopper_id"];
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $product_id = $_POST['product_id'];
    $isOrdered = 0;

    include 'db_connection.php';

    $sql = "INSERT INTO cart (shopper_id, item_id, quantity,is_orderd) VALUES (?, ?, ?,?)";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("iiii", $shopper_id, $item_id, $quantity, $isOrdered);


    if ($stmt->execute()) {

        // header("location: product.php?product_id=$product_id");
        header("location: shoppingCart.php");
    } else {
        echo "Error: Unable to add item to cart.";
    }


    $conn->close();
} else {
    header("location: product.php");
    exit;
}
?>
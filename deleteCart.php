<?php
session_start();


include 'db_connection.php';

if(isset($_POST['item_id']) && isset($_POST['shopper_id'])) {

    $item_id = $_POST['item_id'];
    $shopper_id = $_POST['shopper_id'];
    $sql = "DELETE FROM cart WHERE item_id = ? AND shopper_id = ? and is_orderd = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $item_id, $shopper_id);
    $stmt->execute();

    $stmt->close();
}

$conn->close();


header("Location: shoppingCart.php");
exit;
?>

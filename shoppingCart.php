<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // Redirect to the login page if not logged in
    header("location: shopper_login.php");
    exit;
}

// Get the shopper_id from the session
$shopper_id = $_SESSION["shopper_id"];

// Include database connection
include 'db_connection.php';

// Fetch cart details based on shopper_id
$sql = "SELECT * FROM cart WHERE shopper_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $shopper_id);
$stmt->execute();
$result = $stmt->get_result();

// Array to store cart items
$cart_items = array();

// Fetch item details for each cart item
while ($row = $result->fetch_assoc()) {
    $item_id = $row['item_id'];
    $quantity = $row['quantity'];

    // Fetch item details based on item_id
    $sql_item = "SELECT * FROM Item WHERE item_id = ?";
    $stmt_item = $conn->prepare($sql_item);
    $stmt_item->bind_param("i", $item_id);
    $stmt_item->execute();
    $result_item = $stmt_item->get_result();

    // Add item details to the cart_items array
    while ($row_item = $result_item->fetch_assoc()) {
        $row_item['quantity'] = $quantity; // Add quantity to the item details
        $cart_items[] = $row_item;
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Shopping Cart</h1>
    <div class="row">
        <?php foreach ($cart_items as $item): ?>
            
                <div class="card">
                    <img src="images/item<?php echo $item['item_id']; ?>.jpg" class="card-img-top" alt="Item Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $item['name']; ?></h5>
                        <p class="card-text"><?php echo $item['description']; ?></p>
                        <p>Quantity: <?php echo $item['quantity']; ?></p>
                        <p>Price: <?php echo $item['price']; ?></p>
                    </div>
                </div>
          
        <?php endforeach; ?>
    </div>
    
   <!-- add form here -->
   <form action="proceedOrder.php" method="post">
        <button type="submit" class="btn btn-primary">Place Order</button>
    </form>


</div>

</body>
</html>

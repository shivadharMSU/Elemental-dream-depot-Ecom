<?php
session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {

    header("location: shopper_login.php");
    exit;
}


$shopper_id = $_SESSION["shopper_id"];


include 'db_connection.php';


$sql = "SELECT * FROM cart WHERE shopper_id = ? and is_orderd = 0";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $shopper_id);
$stmt->execute();
$result = $stmt->get_result();


$cart_items = array();


while ($row = $result->fetch_assoc()) {
    $item_id = $row['item_id'];
    $quantity = $row['quantity'];


    $sql_item = "SELECT * FROM Item WHERE item_id = ?";
    $stmt_item = $conn->prepare($sql_item);
    $stmt_item->bind_param("i", $item_id);
    $stmt_item->execute();
    $result_item = $stmt_item->get_result();


    while ($row_item = $result_item->fetch_assoc()) {
        $row_item['quantity'] = $quantity;
        $cart_items[] = $row_item;
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #ffffff;
        }

        .navbar-brand img {
            height: 50px;
            width: auto;
        }

        .navbar-nav {
            margin-left: auto;
        }

        .navbar-nav .nav-link {
            color: #000000;
            margin-left: 10px;
        }

        .jumbotron {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php"><img src="images/logo.jpeg" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Products
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <?php foreach ($products as $product): ?>

                                <li><a class="dropdown-item"
                                        href="product.php?product_id=<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></a>
                                </li>

                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Order</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manageAddress.php">Manage Address</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="shoppingCart.php"><i class="bi bi-cart4"></i> Cart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="?logout=true">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="shopper_login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>


    <br>
    <div class="container">
        <h1>Shopping Cart</h1>
        <div class="row">
            <?php foreach ($cart_items as $item): ?>
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="images/item<?php echo $item['item_id']; ?>.jpeg" class="card-img-top" alt="Item Image"
                                style="max-width: 100%; height: auto;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $item['name']; ?></h5>
                                <p class="card-text"><?php echo $item['description']; ?></p>
                                <p class="card-text">Price: <?php echo $item['price']; ?></p>
                                <p class="card-text">Quantity: <?php echo $item['quantity']; ?></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="d-flex justify-content-end align-items-center p-3">
                                <form action="deleteCart.php" method="post">
                                    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                                    <input type="hidden" name="shopper_id" value="<?php echo $_SESSION["shopper_id"]; ?>">
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>


        <form action="proceedOrder.php" method="post">
            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>

    </div>


</body>

</html>
<?php
session_start();


if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
   
    header("location: shopper_login.php");
    exit;
}

$shopper_id = $_SESSION["shopper_id"];

include 'db_connection.php';

$sql_address = "SELECT * FROM shopper_address WHERE shopper_id = ?";
$stmt_address = $conn->prepare($sql_address);
$stmt_address->bind_param("i", $shopper_id);
$stmt_address->execute();
$result_address = $stmt_address->get_result();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proceed Order</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
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

    <div class="container">
        <h1>Proceed Order</h1>
        <form action="placeOrder.php" method="post">
            <h2>Delivery Address</h2>
            <?php
            while ($row_address = $result_address->fetch_assoc()) {
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="radio" name="address_id" value="' . $row_address['address_id'] . '" required>';
                echo '<label class="form-check-label">' . $row_address['address'] . ', ' . $row_address['city'] . ', ' . $row_address['state'] . ', ' . $row_address['zipCode'] . '</label>';
                echo '</div>';
            }
            ?>

            <h2>Payment Method</h2>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" value="cash" required>
                <label class="form-check-label">Cash</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="payment_method" value="debit_credit_card" required>
                <label class="form-check-label">Debit/Credit Card</label>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Place Order</button>
        </form>
    </div>

</body>

</html>
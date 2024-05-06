<?php
session_start();


function logout()
{

    $_SESSION = array();


    session_destroy();


    header("location: shopper_login.php");
    exit;
}

if (isset($_GET['logout'])) {
    logout();
}

include 'db_connection.php';


$sql = "SELECT * FROM product";
$result = $conn->query($sql);
$products = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

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

        .custom-card {
            background-color: #e3f2fd;
            /* Light blue background */
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

    <div class="container-fluid">
        <div class="row">
            <div class="col">
                <div class="jumbotron">
                    <h1 class="display-4">Welcome to Our E-Commerce Website</h1>
                    <p class="lead">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vel libero
                        velit. Integer volutpat est quis lorem volutpat, sed posuere sapien viverra. Integer vehicula mi
                        at nunc varius, ac dapibus sapien placerat.</p>
                    <hr class="my-4">
                    <p>Nulla nec suscipit odio. Suspendisse non ante nec justo tempor iaculis. Vestibulum sagittis purus
                        id eleifend vehicula.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <?php foreach ($products as $product): ?>
                <div class="col-md-6 mb-4">
                    <div class="card custom-card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                            <p class="card-text"><?php echo $product['description']; ?></p>
                            <a href="product.php?product_id=<?php echo $product['product_id']; ?>"
                                class="btn btn-primary">View Product</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>



    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
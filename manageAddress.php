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


if (isset($_SESSION["shopper_id"])) {
    $shopper_id = $_SESSION["shopper_id"];
    $sql_address = "SELECT * FROM shopper_address WHERE shopper_id = $shopper_id";
    $result_address = $conn->query($sql_address);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <!-- Bootstrap CSS -->
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
        <h1>Manage Addresses</h1>
        <?php if ($result_address->num_rows > 0): ?>
            <ul class="list-group">
                <?php while ($row_address = $result_address->fetch_assoc()): ?>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col">
                                <?php echo $row_address['address'] . ', ' . $row_address['city'] . ', ' . $row_address['state'] . ', ' . $row_address['zipCode']; ?>
                            </div>
                            <div class="col-auto">
                                <a href="edit_address.php?address_id=<?php echo $row_address['address_id']; ?>"
                                    class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i> Edit</a>
                                <a href="deleteAddress.php?address_id=<?php echo $row_address['address_id']; ?>"
                                    class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> Delete</a>

                            </div>
                        </div>
                    </li>
                <?php endwhile; ?>
            </ul>
        <?php else: ?>
            <p>No addresses found.</p>
        <?php endif; ?>
        <form action="addAddress.php" method="get">
            <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-plus"></i> Add Address</button>
        </form>
    </div>

 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
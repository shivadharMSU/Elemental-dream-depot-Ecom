<?php
session_start();

// Function to log out the user
function logout() {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to the login page or any other desired page
    header("location: shopper_login.php");
    exit;
}

// Check if the logout GET parameter is set
if (isset($_GET['logout'])) {
    logout();
}
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
        background-color: #ffffff; /* White Color */
    }
    .navbar-brand img {
        height: 50px;
        width: auto;
    }
    .navbar-nav {
        margin-left: auto;
    }
    .navbar-nav .nav-link {
        color: #000000; /* Black Color */
        margin-left: 10px;
    }
    .jumbotron {
        background-color: #f8f9fa;
    }
    .card {
        max-width: 300px;
        margin: 20px;
    }
    .card-body {
        text-align: center;
    }
    .card-link {
        text-decoration: none;
        color: inherit;
    }
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="images/logo.jpeg" alt="Logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Manage Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Manage Items</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Manage Employee</a>
                </li>
                
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                
                <li class="nav-item">
                    <a class="nav-link" href="?logout=true">Logout</a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="#">Login</a>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="left-section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage Products</h5>
                <p class="card-text">Click here to manage products.</p>
                <a href="manage_products.php" class="card-link btn btn-primary">Go to Manage</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage Items</h5>
                <p class="card-text">Click here to manage items.</p>
                <a href="manage_items.php" class="card-link btn btn-primary">Go to Manage</a>
            </div>
        </div>
    </div>

    <div class="right-section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage Orders</h5>
                <p class="card-text">Click here to manage orders.</p>
                <a href="manage_orders.php" class="card-link btn btn-primary">Go to Manage</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Manage Employees</h5>
                <p class="card-text">Click here to manage employees.</p>
                <a href="manage_employees.php" class="card-link btn btn-primary">Go to Manage</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

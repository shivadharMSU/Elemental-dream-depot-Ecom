<?php
session_start();

// Include database connection
include 'db_connection.php';

// Check if product_id is provided in the URL
if(isset($_GET['product_id'])) {
    // Sanitize the input
    $product_id = $_GET['product_id'];

    // Fetch items based on product_id from the database
    $sql = "SELECT * FROM item WHERE product_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);
} else {
    // Redirect to index.php if product_id is not provided
    header("location: index.php");
    exit;
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card {
            width: 18rem;
            margin: 10px;
            border: 1px solid #ced4da; /* Add border */
            border-radius: 8px; /* Add border radius */
        }
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
    .btn-light-blue {
            background-color: #ADD8E6; /* Light blue color */
            color: #fff; /* Text color */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php"><img src="images/logo.jpeg" alt="Logo"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Products
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <?php foreach($products as $product): ?>
                          
<li><a class="dropdown-item" href="product.php?product_id=<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></a></li>

                        <?php endforeach; ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Order</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                <li class="nav-item">
                    <a class="nav-link" href="shoppingCart.php"><i class="bi bi-cart4"></i> Cart</a>
                </li>
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
    <?php 
        // Splitting items array into chunks of 3
        $chunks = array_chunk($items, 3);
        
        // Loop through each chunk
        foreach ($chunks as $chunk): 
    ?>
        <div class="row">
            <?php foreach ($chunk as $item): ?>
                <div class="col">
                    <div class="card border-0" style="background-color: #E6FBFA;"> <!-- Set grey background color -->
                        <div class="card-body">
                        <img src="images/item<?php echo $item['item_id']; ?>.jpeg" class="card-img-top" alt="Item Image">
                            <h5 class="card-title"><?php echo $item['name']; ?></h5>
                            <p class="card-text"><?php echo $item['description']; ?></p>
                            <form action="add_to_cart.php" method="post">
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Quantity:</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1">
                                </div>
                                $product_id
                                <input type="hidden" name="product_id" value="<?php echo $product_id ?>">
                                <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                                <button type="submit" class="btn btn-light-blue">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</div>


</body>
</html>

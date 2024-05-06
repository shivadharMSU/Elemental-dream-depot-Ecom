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


if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    $sql = "DELETE FROM item WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();

    $stmt->close();


    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_item'])) {
    $item_id = $_POST["item_id"];
    $name = $_POST["name"];
    $product_id = $_POST["product_id"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];
    $sql = "UPDATE item SET name = ?, product_id = ?, description = ?, quantity = ?, price = ? WHERE item_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisssi", $name, $product_id, $description, $quantity, $price, $item_id);
    $stmt->execute();


    $stmt->close();


    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $name = $_POST["name"];
    $product_id = $_POST["product_id"];
    $description = $_POST["description"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];


    $sql = "INSERT INTO item (name, product_id, description, quantity, price) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisss", $name, $product_id, $description, $quantity, $price);
    $stmt->execute();
    $stmt->close();

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


$sql = "SELECT * FROM item";
$result = $conn->query($sql);
$items = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }
}
$conn->close();

// Fetch products from the database for dropdown
$sql_products = "SELECT * FROM product";
$result_products = $conn->query($sql_products);
$products_dropdown = array();
if ($result_products->num_rows > 0) {
    while ($row_product = $result_products->fetch_assoc()) {
        $products_dropdown[] = $row_product;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>

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
        <h2>Items</h2>
        <div class="row">
            <?php foreach ($items as $item): ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $item['name']; ?></h5>
                            <form action="" method="post">
                                <input type="hidden" name="delete_id" value="<?php echo $item['item_id']; ?>">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                data-bs-target="#editModal<?php echo $item['item_id']; ?>">Edit</button>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="editModal<?php echo $item['item_id']; ?>" tabindex="-1"
                    aria-labelledby="editModalLabel<?php echo $item['item_id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel<?php echo $item['item_id']; ?>">Edit Item</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                                    <div class="mb-3">
                                        <label for="itemName" class="form-label">Item Name</label>
                                        <input type="text" class="form-control" id="itemName" name="name"
                                            value="<?php echo $item['name']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="productSelect" class="form-label">Product</label>
                                        <select class="form-select" id="productSelect" name="product_id" required>
                                            <?php foreach ($products_dropdown as $product): ?>
                                                <option value="<?php echo $product['product_id']; ?>" <?php if ($product['product_id'] == $item['product_id'])
                                                       echo "selected"; ?>>
                                                    <?php echo $product['product_name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="itemDescription" class="form-label">Description</label>
                                        <textarea class="form-control" id="itemDescription" name="description"
                                            rows="3"><?php echo $item['description']; ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="itemQuantity" class="form-label">Quantity</label>
                                        <input type="text" class="form-control" id="itemQuantity" name="quantity"
                                            value="<?php echo $item['quantity']; ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="itemPrice" class="form-label">Price</label>
                                        <input type="text" class="form-control" id="itemPrice" name="price"
                                            value="<?php echo $item['price']; ?>">
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="edit_item">Update Item</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="container mt-5">
        <h2>Add New Item</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="mb-3">
                <label for="itemName" class="form-label">Item Name</label>
                <input type="text" class="form-control" id="itemName" name="name" required>
            </div>
            <div class="mb-3">
                <label for="productSelect" class="form-label">Product</label>
                <select class="form-select" id="productSelect" name="product_id" required>
                    <?php foreach ($products_dropdown as $product): ?>
                        <option value="<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="itemDescription" class="form-label">Description</label>
                <textarea class="form-control" id="itemDescription" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="itemQuantity" class="form-label">Quantity</label>
                <input type="text" class="form-control" id="itemQuantity" name="quantity">
            </div>
            <div class="mb-3">
                <label for="itemPrice" class="form-label">Price</label>
                <input type="text" class="form-control" id="itemPrice" name="price">
            </div>
            <button type="submit" class="btn btn-primary" name="add_item">Add Item</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
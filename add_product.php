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

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    include 'db_connection.php';


    $sql = "INSERT INTO product (product_name) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $productName);


    $productName = $_POST["productName"];
    $stmt->execute();


    $stmt->close();


    $conn->close();

    header("location: manage_products.php");
    exit;
}
?>
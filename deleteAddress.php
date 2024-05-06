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


if (isset($_GET["address_id"])) {
    $address_id = $_GET["address_id"];
    $sql_fetch_address = "DELETE FROM shopper_address WHERE address_id = $address_id";
    $result_fetch_address = $conn->query($sql_fetch_address);
    header("location: manageAddress.php");

}
$conn->close();
?>
<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $role_id = $conn->real_escape_string($_POST['designation']);


    $sql = "INSERT INTO employee (name, mobile, email, user_name, password,role_id) 
            VALUES ('$name', '$mobile', '$email', '$username', '$password','$role_id')";

    if ($conn->query($sql) === TRUE) {
        header("location: admin_login.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
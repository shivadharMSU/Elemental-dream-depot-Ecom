<?php
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $name = $conn->real_escape_string($_POST['name']);
    $mobile = $conn->real_escape_string($_POST['mobile']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $role_id = $conn->real_escape_string($_POST['designation']);
    

    // Attempt insert query execution
    $sql = "INSERT INTO employee (name, mobile, email, user_name, password,role_id) 
            VALUES ('$name', '$mobile', '$email', '$username', '$password','$role_id')";
    //  echo $sql;
    if ($conn->query($sql) === TRUE) {
        // Redirect to login page
        header("location: adminRegister.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
?>

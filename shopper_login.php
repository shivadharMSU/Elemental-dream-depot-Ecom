<?php
session_start();


if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: home.php");
    exit;
}


include 'db_connection.php';


$username = $password = "";
$username_err = $password_err = "";


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }


    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }


    if (empty($username_err) && empty($password_err)) {

        $sql = "SELECT shopper_id, username, password FROM shoppers WHERE username = ?";

        if ($stmt = $conn->prepare($sql)) {

            $stmt->bind_param("s", $param_username);


            $param_username = $username;


            if ($stmt->execute()) {

                $stmt->store_result();


                if ($stmt->num_rows == 1) {

                    $stmt->bind_result($shopper_id, $username, $hashed_password);
                    if ($stmt->fetch()) {
                        if ($password === $hashed_password) {

                            session_start();


                            $_SESSION["loggedin"] = true;
                            $_SESSION["shopper_id"] = $shopper_id;
                            $_SESSION["username"] = $username;


                            header("location: home.php");
                        } else {

                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else {

                    $username_err = "No account found with that username.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }


            $stmt->close();
        }
    }


    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
            <img src="images/logo.jpeg" alt="Logo" width="650" height="200">
               <h1 style="color: lightblue;">Elemental Home Depot</h1>

                <div class="card">
                    <h2 class="card-title text-center">Shopper Login</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text"
                                class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                                id="username" name="username" value="<?php echo $username; ?>">
                            <div class="invalid-feedback"><?php echo $username_err; ?></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"
                                id="password" name="password">
                            <div class="invalid-feedback"><?php echo $password_err; ?></div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
                <p class="mt-3 text-center">Don't have an account? <a href="register.php">Register here</a></p>
                <p class="mt-3 text-center">Are you admin? <a href="admin_login.php">admin</a></p>
            </div>
        </div>
    </div>
</body>

</html>
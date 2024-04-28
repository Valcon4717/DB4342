<!--
/**
 * CS 4342 Database Management
 * 
 * This file contains create account functionality for the user.
 * 
 * @author Jazmin Salmon, Valeria Contreras, Eric Gardea, and Fernando Sepulveda
 * @version 1.0
 */
-->

<?php
session_start();
require_once("config.php");
$message = "";

// Check if the form data has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assign the POST data to variables
    $input_email = $_POST['username'] ?? '';
    $input_password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate the input
    if (empty($input_email) || empty($input_password) || empty($confirm_password)) {
        $message = '<div class="alert alert-danger" role="alert">Please fill in all fields.</div>';
    } elseif ($input_password !== $confirm_password) {
        $message = '<div class="alert alert-danger" role="alert">Passwords do not match.</div>';
    } else {
        // Check if the username exists in the 'individual' table
        $query = "SELECT * FROM individual WHERE IndEmail_address = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $input_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // The user exists, proceed to create an account

            // First, hash the password
            $hashed_password = password_hash($input_password, PASSWORD_DEFAULT);

            // Create the account by updating the 'individual' table with the hashed password
            $update_query = "UPDATE individual SET IndPassword = ? WHERE IndEmail_address = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ss", $hashed_password, $input_email);
            $update_stmt->execute();

            if ($update_stmt->affected_rows > 0) {
                // Account created successfully
                $_SESSION['logged_in'] = true;
                $_SESSION['user'] = $input_email;
                $message = '<div class="alert alert-success" role="alert">Account created successfully! Redirecting to login page...</div>';
                $message .= "<script>
                    setTimeout(function() {
                        window.location.href = 'login.php';
                    }, 2000);
                </script>";
            } else {
                $message = '<div class="alert alert-danger" role="alert">Failed to create an account.</div>';
            }
        } else {
            // The user does not exist
            $message = '<div class="alert alert-danger" role="alert">No account found with that email. Please try again.</div>';
        }
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/index.css">
    <link rel="stylesheet" href="./css/createAcc.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="./assets/utep.jpg" alt="UTEP Logo" width="40" height="40">
                &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: 600;">UTEP Instructors</span>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                </ul>
            </div>
        </div>
    </nav>
    <div class="createAcc-container">
        <div class="createAcc-form-container">
            <div class="createAcc-text">
                <div class="createAcc-title">Create an Account</div>
                <div class="createAcc-sub">Please enter your details below</div>
                <?php
                echo $message;
                ?>
            </div>
            <form class="createAcc-form" action="createAcc.php" method="post">
                <div class="form">
                    <div class="form">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="username" id="username" autocomplete="username" aria-label="default input example">
                    </div>
                    <div class="form">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" id="password" autocomplete="new-password" aria-label="default input example">
                    </div>
                    <div class="form">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" autocomplete="new-password" aria-label="default input example">
                    </div>
                    <div class="createAcc-button-container">
                        <button type="submit" style="font-weight: 600;" class="button-createAcc-complete">Create Account</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="createAcc-image-container">
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
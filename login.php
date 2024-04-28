<!--
/**
 * CS 4342 Database Management
 * 
 * This file contains login functionality for the user.
 * 
 * @author Jasmin Salmon, Valeria Contreras, Eric Gardea, and Fernando Sepulveda
 * @version 1.0
 */
-->

<?php
session_start();
require_once("config.php");
$message = "";

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $input_username = $_POST['username'] ?? '';
  $input_password = $_POST['password'] ?? '';

  // Check if the username and password are empty
  if (empty($input_username) || empty($input_password)) {
    $message = '<div class="alert alert-danger" role="alert">Please enter username and password.</div>';
  } else {
    // Check for admin login
    $admin_query = "SELECT Name FROM adminlogins WHERE Email = ? AND Password = ?";
    $admin_stmt = $conn->prepare($admin_query);
    $admin_stmt->bind_param("ss", $input_username, $input_password);
    $admin_stmt->execute();
    $admin_result = $admin_stmt->get_result();

    if ($admin_result->num_rows > 0) {
      // Admin login successful
      $_SESSION['user'] = $input_username;
      $_SESSION['admin_logged_in'] = true;
      header("Location: admin.php");
      exit();
    }

    // Check for individual login
    $query = "SELECT Ind_id, IndPassword FROM individual WHERE IndEmail_address = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $input_username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0 && $row = $result->fetch_assoc()) {
      if (password_verify($input_password, $row['IndPassword'])) {
        $ind_id_length = strlen((string)$row['Ind_id']);

        if ($ind_id_length === 6) {
          $message = '<div class="alert alert-success" role="alert">Login Successful! Redirecting to student page...</div>';
          $redirectPage = "student.php";
        } elseif ($ind_id_length === 8) {
          $message = '<div class="alert alert-success" role="alert">Login Successful! Redirecting to instructor page...</div>';
          $redirectPage = "instructor.php";
        }
        $_SESSION['user'] = $input_username;
        $_SESSION['logged_in'] = true;

        $message .= "<script>
                    setTimeout(function() {
                        window.location.href = '$redirectPage';
                    }, 2000);
                </script>";
      } else {
        $message = '<div class="alert alert-danger" role="alert">Invalid password.</div>';
      }
    } else {
      $message = '<div class="alert alert-danger" role="alert">User not found.</div>';
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
  <link rel="stylesheet" href="./css/login.css">
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
  <div class="login-container">
    <div class="login-form-container">
      <div class="login-text">
        <div class="login-title">Welcome back!</div>
        <div class="login-sub">Please enter your details below</div>
        <?php
        echo $message;
        ?>
      </div>
      <form class="login-form" action="login.php" method="post">
        <div class="form">
          <label for="username" class="form-label">Username</label>
          <input type="email" class="form-control" name="username" id="username" aria-label="default input example">
        </div>
        <div class="form">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" aria-label="default input example">
        </div>
        <div class="login-button-container">
          <button type="submit" style="font-weight: 600;" name="Submit" class="button-login-complete">Login</button>
        </div>
      </form>
    </div>
    <div class="login-image-container">
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
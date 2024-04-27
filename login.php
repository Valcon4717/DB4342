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


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CS 4342 User Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <div style="margin-top: 20px" class="container">
    <h1>User Login</h1>
    <form action="index.php" method="post">
      <div class="form-group">
        <label for="username">User Name</label>
        <input class="form-control" type="text" id="username" name="username">
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input class="form-control" type="password" id="password" name="password">
      </div>
      <div class="form-group">
        <input class="btn btn-primary" name='Submit' type="submit" value="Submit">
      </div>
    </form>
    <a href="create_user.php">Don't have an account? Create one now!</a><br><br>
  </div>
  <!-- jQuery and JS bundle w/ Popper.js -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>


<?php

session_start();
require_once("config.php");
$_SESSION['logged_in'] = false;

if (!empty($_POST)) {
  if (isset($_POST['Submit'])) {
    $input_username = isset($_POST['username']) ? $_POST['username'] : " ";
    $input_password = isset($_POST['password']) ? $_POST['password'] : " ";

    $queryUser = "SELECT * FROM User  WHERE Uusername='" . $input_username . "' AND UPassword='" . $input_password . "';";
    $resultUser = $conn->query($queryUser);

    if ($resultUser->num_rows > 0) {
      //if there is a result, that means that the user was found in the database
      $_SESSION['user'] = $input_username;
      $_SESSION['logged_in'] = true;

      echo "Session logged_in is: " . $_SESSION['logged_in'];

      // You can comment the next line (header) to check if the user was successfully logged in. 
      // But it will not redirect to the student_menu file automatically.
      header("Location: studentsCode/student_menu.php");
    } else {
      echo "User not found.";
    }
    die();
  }
}
?>
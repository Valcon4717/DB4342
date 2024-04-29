<!--
/**
 * CS 4342 Database Management
 * 
 * This file contains admin functionality for the user.
 * 
 * @author Jasmin Salmon, Valeria Contreras, Eric Gardea, and Fernando Sepulveda
 * @version 1.0
 */
-->

<?php
/*
* Reference for tables: https://getbootstrap.com/docs/4.5/content/tables/
*/

session_start();
require_once('../config.php');
require_once('../validate_session.php');
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/index.css">
  <link rel="stylesheet" href="./css/student.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="./assets/utep.jpg" alt="UTEP Logo" width="40" height="40">
        &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: 600;">UTEP Admin</span>
      </a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <button type="button" class="button-top-signup">
              <a class="nav-link" href="index.php" style="font-weight: 600;">Log Out</a>
            </button>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="adminReport.php" style="font-weight: 600;">Reports</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="adminViewEdit.php" style="font-weight: 600;">Procedures & Views</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  Admin
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>

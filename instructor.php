<!--
/**
 * CS 4342 Database Management
 * 
 * This file contains instructor functionality for the user.
 * 
 * @author Jasmin Salmon, Valeria Contreras, Eric Gardea, and Fernando Sepulveda
 * @version 1.0
 */
-->

<?php
session_start();
require_once("config.php");

$instructorID = $_SESSION['user_id'] ?? null;
$instructorFirstName = $_SESSION['user_first_name'] ?? null;

function fetchDataFromView($conn, $viewName)
{
  $query = "SELECT * FROM " . $viewName;
  $result = $conn->query($query);

  if ($result) {
    return $result->fetch_all(MYSQLI_ASSOC);
  } else {
    die("Error fetching data: " . $conn->error);
  }
}

function fetchInstructorBudgetInfo($conn, $instructorID)
{
  $query = "SELECT * FROM view_budget_info_admin WHERE Iid = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $instructorID);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result) {
    return $result->fetch_assoc();
  } else {
    die("Error fetching data: " . $conn->error);
  }
}

// Fetch data from views
$researchProjectsData = fetchDataFromView($conn, 'view_r16_research_project_viewer');
$instructorInfoData = fetchDataFromView($conn, 'view_r24_instructor_info_viewer');
$labInfoData = fetchDataFromView($conn, 'view_r7_lab_info_viewer');
$courseInfoData = fetchDataFromView($conn, 'view_course_info_viewer');
$studentInfoData = fetchDataFromView($conn, 'view_student_info_viewer');
$instructorBudgetInfo = fetchInstructorBudgetInfo($conn, $instructorID);
?>

<!doctype html>
<html lang="en">

<head>
  <style>
    .instructor-name-cell {
      white-space: nowrap;
      max-width: 150px;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .max-students-cell {
      width: 150px;
    }

    .table th,
    .table td {
      padding: 0.5rem;
    }
  </style>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/index.css">
  <link rel="stylesheet" href="./css/instructor.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center" href="#">
        <img src="./assets/utep.jpg" alt="UTEP Logo" width="40" height="40">
        &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight: 600;">UTEP Instructors</span>
      </a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <button type="button" class="button-top-signup">
              <a class="nav-link" href="index.php" style="font-weight: 600;">Log Out</a>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container my-4">
    <div class="instructor-name-container">
      <span style="font-size: 2rem; font-weight: 700; color: #041e42">Welcome <span class="instructor-name" style="color: #ff8200;"><?php echo htmlspecialchars($instructorFirstName); ?></span>!</span>
    </div>

    <h4 style="padding-top: 3rem">Budget Information</h4>
    <?php if ($instructorBudgetInfo) : ?>
      <table class="table table-striped" style="width: 65%">
        <thead>
          <tr>
            <th>Instructor</th>
            <th style="text-align: center;">Conferences</th>
            <th style="text-align: center;">Teaching</th>
            <th style="text-align: center;">Events</th>
            <th style="text-align: center;">Training</th>
            <th style="text-align: center;">Total</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?= htmlspecialchars($instructorBudgetInfo['Instructor']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($instructorBudgetInfo['Conferences']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($instructorBudgetInfo['Teaching']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($instructorBudgetInfo['Events']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($instructorBudgetInfo['Training']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($instructorBudgetInfo['Total']) ?></td>
          </tr>
        </tbody>
      </table>
    <?php endif; ?>


    <h4 style="padding-top: 2rem">Research Projects</h4>
    <table class="table table-striped" style="width: 70%">
      <thead>
        <tr>
          <th>Research Area</th>
          <th>Instructor Name</th>
          <th style="text-align: center;">Papers Published</th>
          <th style="text-align: center;">Max Capacity</th>
          <th style="text-align: center;">Students Supervised</th>
          <th style="text-align: center;">Lab ID</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($researchProjectsData as $row) : ?>
          <tr>
            <td><?= htmlspecialchars($row['Research_Area']) ?></td>
            <td><?= htmlspecialchars($row['Instructor_Name']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Number_of_Papers_Published']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Max_Capacity']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Number_of_Students_Supervised']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Lab_ID']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h4 style="padding-top: 2rem;">Instructor Info</h4>
    <table class="table table-striped" style="width: 95%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Instructor Type</th>
          <th>Research Topic</th>
          <th>Email</th>
          <th style="text-align: center;">Papers Published</th>
          <th style="text-align: center;">Research Lab ID</th>
          <th style="text-align: center;">Students Assigned</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($instructorInfoData as $row) : ?>
          <tr>
            <td><?= htmlspecialchars($row['Name']) ?></td>
            <td><?= htmlspecialchars($row['Instructor_Type']) ?></td>
            <td><?= htmlspecialchars($row['Research_Topic']) ?></td>
            <td><?= htmlspecialchars($row['Email']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Number_of_Papers_Published']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Research_Lab_ID']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Number_of_Students_Assigned']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h4 style="padding-top: 2rem;">Lab Info</h4>
    <table class="table table-striped" style="width: 85%">
      <thead>
        <tr>
          <th>Lab ID</th>
          <th>Status</th>
          <th>Instructor</th>
          <th>Research Topic</th>
          <th style="text-align: center;">Max Capacity</th>
          <th style="text-align: center;">Students Assigned</th>
          <th style="text-align: center;">Current Capacity</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($labInfoData as $row) : ?>
          <tr>
            <td><?= htmlspecialchars($row['Lab_ID']) ?></td>
            <td><?= htmlspecialchars($row['Status']) ?></td>
            <td><?= htmlspecialchars($row['Instructor']) ?></td>
            <td><?= htmlspecialchars($row['Research_Topic']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Max_Capacity']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Number_of_Students_Assigned']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Current_Capacity']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h4 style="padding-top: 2rem;">Course Info</h4>
    <table class="table table-striped" style="width: 75%">
      <thead>
        <tr>
          <th>Course Name</th>
          <th>Location</th>
          <th class="instructor-name-cell">Instructor Name</th>
          <th style="text-align: center;" class="max-students-cell">Max Students</th>
          <th style="text-align: center;">Course Number</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($courseInfoData as $row) : ?>
          <tr>
            <td><?= htmlspecialchars($row['Cname']) ?></td>
            <td><?= htmlspecialchars($row['Clocation']) ?></td>
            <td class="instructor-name-cell"><?= htmlspecialchars($row['Instructor_Name']) ?></td>
            <td style="text-align: center;" class="max-students-cell"><?= htmlspecialchars($row['Cmax_students']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Cnumber']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h4 style="padding-top: 2rem;">Student Info</h4>
    <table class="table table-striped" style="width: 60%">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Middle Name</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($studentInfoData as $row) : ?>
          <tr>
            <td><?= htmlspecialchars($row['Fname']) ?></td>
            <td><?= htmlspecialchars($row['Lname']) ?></td>
            <td><?= htmlspecialchars($row['Mname']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
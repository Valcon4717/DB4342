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
session_start();
require_once("config.php");

$adminFirstName = $_SESSION['user_first_name'] ?? null;
$generalReports = [];

$semesterReports = [];

if (isset($_POST['semester'])) {
  $selectedSemester = $_POST['semester'];

  // Convert the posted value to a human-readable semester string
  // Assuming the values are in the format of 'spring_2024', 'fall_2023', etc.
  $humanReadableSemester = str_replace('_', ' ', ucwords($selectedSemester));

  // Array to hold SQL statements for different reports
  $reportSqlStatements = [
      'courses' => "SELECT * FROM report_courses_per_semester WHERE Semester = '$humanReadableSemester'",
      'budget' => "SELECT * FROM report_r11_budget_per_semester WHERE Semester = '$humanReadableSemester'",
      'research_projects' => "SELECT * FROM report_research_project_per_semester WHERE Semester = '$humanReadableSemester'",
  ];

  // Execute each SQL query and store the results
  foreach ($reportSqlStatements as $reportType => $sql) {
      if ($result = $conn->query($sql)) {
          while ($row = $result->fetch_assoc()) {
              $semesterReports[$reportType][$humanReadableSemester][] = $row;
          }
      } else {
          echo "Error in $reportType report: " . $conn->error;
      }
  }
}

if (isset($_POST['general_report'])) {
  $selectedGeneralReport = $_POST['general_report'];

  switch ($selectedGeneralReport) {
    case 'labs':
      $sql = "SELECT * FROM report_r6_available_labs";
      break;
    case 'research_projects':
      $sql = "SELECT * FROM report_r15_research_projects";
      break;
    case 'courses':
      $sql = "SELECT * FROM report_r3_instructor_number_of_courses";
      break;
    default:
      $sql = "";
      break;
  }

  if (!empty($sql)) {
    if ($result = $conn->query($sql)) {
      while ($row = $result->fetch_assoc()) {
        $generalReports[$selectedGeneralReport][] = $row;
      }
    } else {
      echo "Error: " . $conn->error;
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
            <a class="nav-link" href="admin.php" style="font-weight: 600;">Reports</a>
          </li>
          &nbsp;&nbsp;&nbsp;
          <li class="nav-item">
            <a class="nav-link" href="adminViewEdit.php" style="font-weight: 600;">View and Edit</a>
          </li>
          &nbsp;&nbsp;&nbsp;
          <li class="nav-item">
            <button type="button" class="button-top-signup">
              <a class="nav-link" href="index.php" style="font-weight: 600;">Log Out</a>
            </button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-3">
    <div class="admin-name-container">
      <span style="font-size: 2rem; font-weight: 700; color: #041e42">Welcome <span class="admin-name" style="color: #ff8200;"><?php echo htmlspecialchars($adminFirstName); ?></span>!</span>
    </div>
    <div class="row">
      <div class="col-md-6">
        <h4 style="padding-top: 5rem; padding-bottom: 1rem;">Reports per Semester</h4>
        <form method="post" action="">
          <div class="form-group">
            <label for="semesterSelect">Select Semester:</label>
            <select class="form-control" id="semesterSelect" name="semester">
              <option value="spring_2024">Spring 2024</option>
              <option value="fall_2023">Fall 2023</option>
            </select>
          </div>
          <div class="mt-4">
            <button type="submit" class="btn btn-primary" style="background-color: #041e42;">Submit</button>
          </div>
        </form>
        <?php if (!empty($semesterReports)) : ?>
    <?php foreach ($semesterReports as $reportType => $reportsBySemester) : ?>
        <?php foreach ($reportsBySemester as $semester => $reports) : ?>
            <h3><?php echo htmlspecialchars($semester) . ' - ' . ucwords(str_replace("_", " ", $reportType)); ?></h3>
            <table class="table">
                <thead>
                    <tr>
                        <?php foreach (array_keys($reports[0]) as $column) : ?>
                            <th><?php echo htmlspecialchars($column); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reports as $report) : ?>
                        <tr>
                            <?php foreach ($report as $value) : ?>
                                <td><?php echo htmlspecialchars($value); ?></td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endforeach; ?>
    <?php endforeach; ?>
<?php endif; ?>

      </div>
      <div class="col-md-6">
        <h4 style="padding-top: 5rem; padding-bottom: 1rem;">General Reports</h4>
        <form method="post" action="">
          <div class="form-group">
            <label for="generalReportSelect">Select Report Type:</label>
            <select class="form-control" id="generalReportSelect" name="general_report">
              <option value="labs">Labs</option>
              <option value="research_projects">Research Projects</option>
              <option value="courses">Courses</option>
            </select>
          </div>
          <div class="mt-4">
            <button type="submit" class="btn btn-primary" style="background-color: #041e42;">Submit</button>
          </div>      
          <div style="padding-bottom: 4rem;">
          </div>  
        </form>
        <?php if (!empty($generalReports)) : ?>
          <?php foreach ($generalReports as $type => $reports) : ?>
            <h3><?php echo ucwords(str_replace("_", " ", $type)); ?></h3>
            <table class="table">
              <thead>
                <tr>
                  <?php foreach (array_keys($reports[0]) as $column) : ?>
                    <th><?php echo $column; ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($reports as $report) : ?>
                  <tr>
                    <?php foreach ($report as $value) : ?>
                      <td><?php echo $value; ?></td>
                    <?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
<?php
session_start();
require_once('config.php');
require_once('validate_session.php');

// Initialize variables to store fetched reports
$semesterReports = [];
$generalReports = [];

// Fetch reports per semester based on form submission
if (isset($_POST['semester'])) {
    $selectedSemester = $_POST['semester'];
    
    // Query database to fetch reports for the selected semester
    // You'll need to adjust this query based on your database structure
    switch ($selectedSemester) {
        case 'spring_2024':
        case 'fall_2023':
            $semesterTables = array(
                'report_r11_budget_per_semester',
                'report_research_project_per_semester',
                'report_courses_per_semester'
            );
            break;
        // Add more cases for other semesters if needed
        default:
            $semesterTables = array();
            break;
    }

    // Fetch reports from each table for the selected semester
    foreach ($semesterTables as $table) {
        $sql = "SELECT * FROM $table WHERE Semester = '$selectedSemester'";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $semesterReports[$table][] = $row; // Store entire row in the array
            }
        }
    }
}

// Fetch general reports based on form submission
if (isset($_POST['general_report'])) {
    $selectedGeneralReport = $_POST['general_report'];
    // Query database to fetch general reports for the selected type
    // You'll need to adjust this query based on your database structure
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

    // Execute query to fetch general reports
    if (!empty($sql)) {
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $generalReports[$selectedGeneralReport][] = $row; // Store entire row in the array
            }
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
        </ul>
      </div>
    </div>
  </nav>
  Admin Reports
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2>Reports per Semester</h2>
        <form method="post" action="">
          <div class="form-group">
            <label for="semesterSelect">Select Semester:</label>
            <select class="form-control" id="semesterSelect" name="semester">
              <option value="spring_2024">Spring 2024</option>
              <option value="fall_2023">Fall 2023</option>
              <!-- Add more semesters as needed -->
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <!-- Display fetched reports per semester -->
        <?php if (!empty($semesterReports)): ?>
          <?php foreach ($semesterReports as $table => $reports): ?>
            <h3>Reports for <?php echo $table; ?></h3>
            <table class="table">
              <thead>
                <tr>
                  <?php foreach (array_keys($reports[0]) as $column): ?>
                    <th><?php echo $column; ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($reports as $report): ?>
                  <tr>
                    <?php foreach ($report as $value): ?>
                      <td><?php echo $value; ?></td>
                    <?php endforeach; ?>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="col-md-6">
        <h2>General Reports</h2>
        <form method="post" action="">
          <div class="form-group">
            <label for="generalReportSelect">Select Report Type:</label>
            <select class="form-control" id="generalReportSelect" name="general_report">
              <option value="labs">Labs</option>
              <option value="research_projects">Research Projects</option>
              <option value="courses">Courses</option>
              <!-- Add more options for other report types as needed -->
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <!-- Display fetched general reports -->
        <?php if (!empty($generalReports)): ?>
          <?php foreach ($generalReports as $type => $reports): ?>
            <h3><?php echo ucwords(str_replace("_", " ", $type)); ?></h3>
            <table class="table">
              <thead>
                <tr>
                  <?php foreach (array_keys($reports[0]) as $column): ?>
                    <th><?php echo $column; ?></th>
                  <?php endforeach; ?>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($reports as $report): ?>
                  <tr>
                    <?php foreach ($report as $value): ?>
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

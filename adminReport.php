<?php
session_start();
require_once('../config.php');
require_once('../validate_session.php');

// Initialize variable to store fetched reports
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
        $sql = "SELECT * FROM $table";
        $result = $conn->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                // Assuming 'report_name' is the column name containing the report names
                $semesterReports[] = $row['report_name'];
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
        case 'instructor_info':
            $sql = "SELECT * FROM report_r22_instructor_info_admin";
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
                // Assuming 'report_name' is the column name containing the report names
                $generalReports[] = $row['report_name'];
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
          <h3>Reports for <?php echo $selectedSemester; ?></h3>
          <?php foreach ($semesterReports as $report): ?>
            <p><?php echo $report; ?></p>
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
              <option value="instructor_info">Instructor Info</option>
              <!-- Add more options for other report types as needed -->
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        <!-- Display fetched general reports -->
        <?php if (!empty($generalReports)): ?>
          <h3>General Reports</h3>
          <?php foreach ($generalReports as $report): ?>
            <p><?php echo $report; ?></p>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
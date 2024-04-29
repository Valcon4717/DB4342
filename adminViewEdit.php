<!--
/**
 * CS 4342 Database Management
 * 
 * This file contains admin view and edit functionality for the user.
 * 
 * @author Jasmin Salmon, Valeria Contreras, Eric Gardea, and Fernando Sepulveda
 * @version 1.0
 */
-->
<?php
session_start();
require_once("config.php");

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

$studentInfoData = fetchDataFromView($conn, 'view_student_info_admin');
$instructorInfoData = fetchDataFromView($conn, 'view_r22_instructor_info_admin');
$labInfoData = fetchDataFromView($conn, 'view_r7_lab_info_viewer');
$courseInfoData = fetchDataFromView($conn, 'view_r3_course_info_admin');
$researchProjectData = fetchDataFromView($conn, 'view_r16_research_project_viewer');
$supervisionData = fetchDataFromView($conn, 'view_r28_supervision_admin');
$individualInfoData = fetchDataFromView($conn, 'view_r22_individual_info_admin');
$budgetInfoData = fetchDataFromView($conn, 'view_budget_info_admin');
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
    <h4 style="padding-top: 3rem">Individual Information</h4>
    <table class="table table-striped" style="width: 70%">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Middle Name</th>
          <th>Last Name</th>
          <th>Email Address</th>
          <th style="text-align: center;">Date of Birth</th>
          <th style="text-align: center;">ID</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($individualInfoData as $row) : ?>
          <tr>
            <td><?= htmlspecialchars($row['IndFname']) ?></td>
            <td><?= htmlspecialchars($row['IndMname']) ?></td>
            <td><?= htmlspecialchars($row['IndLname']) ?></td>
            <td><?= htmlspecialchars($row['IndEmail_address']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['IndDob']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Ind_id']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="container mt-3">
    <h4 style="padding-top: 2rem">Budget Information</h4>
    <table class="table table-striped" style="width: 65%">
      <thead>
        <tr>
          <th>Instructor</th>
          <th style="text-align: center;">Conferences</th>
          <th style="text-align: center;">Teaching</th>
          <th style="text-align: center;">Events</th>
          <th style="text-align: center;">Training</th>
          <th style="text-align: center;">Total</th>
          <th style="text-align: center;">ID</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($budgetInfoData as $row) : ?>
          <tr>
            <td><?= htmlspecialchars($row['Instructor']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Conferences']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Teaching']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Events']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Training']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Total']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Iid']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="container mt-3">
    <h4 style="padding-top: 2rem">Student Information</h4>
    <table class="table table-striped" style="width: 80%">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Middle Name</th>
          <th>Last Name</th>
          <th>Email</th>
          <th>Date of Birth</th>
          <th>Phone Number</th>
          <th style="text-align: center;">ID</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($studentInfoData as $row) : ?>
          <tr>
            <td><?= htmlspecialchars($row['Fname']) ?></td>
            <td><?= htmlspecialchars($row['Mname']) ?></td>
            <td><?= htmlspecialchars($row['Lname']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['DOB']) ?></td>
            <td><?= htmlspecialchars($row['Phone_Num']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Id']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <div class="container mt-3">
    <h4 style="padding-top: 2rem">Instructor Information</h4>
    <table class="table table-striped" style="width: 100%">
      <thead>
        <tr>
          <th>Name</th>
          <th>Instructor Type</th>
          <th>Email</th>
          <th>Gender</th>
          <th>Date of Birth</th>
          <th>Phone Number</th>
          <th style="text-align: center;">Seniority</th>
          <th style="text-align: center;">Instructor ID</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($instructorInfoData as $row) : ?>
          <tr>
            <td><?= htmlspecialchars($row['Name']) ?></td>
            <td><?= htmlspecialchars($row['Instructor_Type']) ?></td>
            <td><?= htmlspecialchars($row['Email']) ?></td>
            <td><?= htmlspecialchars($row['Gender']) ?></td>
            <td><?= htmlspecialchars($row['Date_of_Birth']) ?></td>
            <td><?= htmlspecialchars($row['Phone_Number']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Seniority_Length']) ?></td>
            <td style="text-align: center;"><?= htmlspecialchars($row['Instructor_ID']) ?></td>
            <td style="text-align: center;">
              <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteInstructor(<?= htmlspecialchars($row['Instructor_ID']) ?>)">Delete</button>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addInstructorModal" style="background-color: #041e42;">
      Add Instructor
    </button>
    <div class="modal fade" id="addInstructorModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalLabel">New Instructor</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form action="adminAdd.php" method="post" class="row g-3">
              <div class="col-md-6">
                <label for="instructor_id" class="form-label">Instructor ID</label>
                <input type="text" class="form-control" name="instructor_id" id="instructor_id" required>
              </div>
              <div class="col-md-6">
                <label for="instructor_type" class="form-label">Instructor Type</label>
                <input type="text" class="form-control" name="instructor_type" id="instructor_type" required>
              </div>
              <div class="col-md-6">
                <label for="email_address" class="form-label">Email</label>
                <input type="email" class="form-control" name="email_address" id="email_address" required>
              </div>
              <div class="col-md-6">
                <label for="phone_number" class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="phone_number" id="phone_number" required>
              </div>
              <div class="col-md-4">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" id="first_name" required>
              </div>
              <div class="col-md-4">
                <label for="middle_name" class="form-label">Middle Name</label>
                <input type="text" class="form-control" name="middle_name" id="middle_name">
              </div>
              <div class="col-md-4">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" id="last_name" required>
              </div>
              <div class="col-md-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" name="gender" id="gender" required>
                  <option selected disabled value="">Choose...</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="col-md-3">
                <label for="dob" class="form-label">Date of Birth</label>
                <input type="date" class="form-control" name="dob" id="dob" required>
              </div>
              <div class="col-md-3">
                <label for="seniority_length" class="form-label">Seniority</label>
                <input type="number" class="form-control" name="seniority_length" id="seniority_length" required>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-primary" style="background-color: #041e42;">Add Instructor</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      function deleteInstructor(instructorId) {
        if (confirm('Are you sure you want to delete this instructor?')) {
          window.location.href = 'adminDelete.php?Iid=' + instructorId;
        }
      }
    </script>

    <div class="container mt-3">
      <h4 style="padding-top: 2rem">Lab Information</h4>
      <table class="table table-striped" style="width: 85%">
        <thead>
          <tr>
            <th>Instructor</th>
            <th>Research Topic</th>
            <th>Status</th>
            <th style="text-align: center;">Lab ID</th>
            <th style="text-align: center;">Max Capacity</th>
            <th style="text-align: center;">Students Assigned</th>
            <th style="text-align: center;">Current Capacity</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($labInfoData as $row) : ?>
            <tr>
              <td><?= htmlspecialchars($row['Instructor']) ?></td>
              <td><?= htmlspecialchars($row['Research_Topic']) ?></td>
              <td><?= htmlspecialchars($row['Status']) ?></td>
              <td style="text-align: center;"><?= htmlspecialchars($row['Lab_ID']) ?></td>
              <td style="text-align: center;"><?= htmlspecialchars($row['Max_Capacity']) ?></td>
              <td style="text-align: center;"><?= htmlspecialchars($row['Number_of_Students_Assigned']) ?></td>
              <td style="text-align: center;"><?= htmlspecialchars($row['Current_Capacity']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="container mt-3">
      <h4 style="padding-top: 2rem">Course Information</h4>
      <table class="table table-striped" style="width: 80%">
        <thead>
          <tr>
            <th>Course Name</th>
            <th>Instructor</th>
            <th style="text-align: center;">Course Number</th>
            <th style="text-align: center;">Location</th>
            <th style="text-align: center;">Max Students</th>
            <th style="text-align: center;">ID</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($courseInfoData as $row) : ?>
            <tr>
              <td><?= htmlspecialchars($row['Cname']) ?></td>
              <td><?= htmlspecialchars($row['Instructor_Name']) ?></td>
              <td style="text-align: center;"><?= htmlspecialchars($row['Cnumber']) ?></td>
              <td style="text-align: center;"><?= htmlspecialchars($row['Clocation']) ?></td>
              <td style="text-align: center;"><?= htmlspecialchars($row['Cmax_students']) ?></td>
              <td style="text-align: center;"><?= htmlspecialchars($row['Iid']) ?></td>
              <td style="text-align: center;">
                <button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteCourse(<?= htmlspecialchars($row['Cnumber']) ?>, '<?= htmlspecialchars(addslashes($row['Clocation'])) ?>')">Delete</button>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <button type="button" class="btn btn-primary" style="background-color: #041e42;" data-bs-toggle="modal" data-bs-target="#addCourseModal">
        Add Course
      </button>
      <div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="addCourseModalLabel">New Course</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form action="adminCourseAdd.php" method="post" class="row g-3">
                <input type="hidden" name="action" value="add_course">
                <div class="col-md-6">
                  <label for="course_number" class="form-label">Course Number</label>
                  <input type="text" class="form-control" name="course_number" required>
                </div>
                <div class="col-md-6">
                  <label for="course_name" class="form-label">Course Name</label>
                  <input type="text" class="form-control" name="course_name" required>
                </div>
                <div class="col-md-6">
                  <label for="course_location" class="form-label">Location</label>
                  <input type="text" class="form-control" name="course_location" required>
                </div>
                <div class="col-md-6">
                  <label for="max_students" class="form-label">Max Students</label>
                  <input type="number" class="form-control" name="max_students" required>
                </div>
                <div class="col-md-6">
                  <label for="instructor_id" class="form-label">Instructor ID</label>
                  <input type="text" class="form-control" name="instructor_id" required>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-primary" style="background-color: #041e42;">Add Course</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>

    <script>
      function deleteCourse(courseNumber, courseLocation) {
        if (confirm('Are you sure you want to delete this course?')) {
          window.location.href = 'adminDelete.php?course_number=' + courseNumber + '&course_location=' + encodeURIComponent(courseLocation);
        }
      }
    </script>

    <div class="container mt-3">
      <h4 style="padding-top: 2rem">Research Project Information</h4>
      <table class="table table-striped" style="width: 75%">
        <thead>
          <tr>
            <th>Research Area</th>
            <th>Instructor</th>
            <th style="text-align: center;">Papers Published</th>
            <th style="text-align: center;">Max Capacity</th>
            <th style="text-align: center;">Students Supervised</th>
            <th style="text-align: center;">Lab ID</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($researchProjectData as $row) : ?>
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
    </div>

    <div class="container mt-3">
      <h4 style="padding-top: 2rem">Supervision Information</h4>
      <table class="table table-striped" style="width: 60%">
        <thead>
          <tr>
            <th>Student Name</th>
            <th>Supervisor Name</th>
            <th>Start Date</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($supervisionData as $row) : ?>
            <tr>
              <td><?= htmlspecialchars($row['Student_Name']) ?></td>
              <td><?= htmlspecialchars($row['Supervisor_Name']) ?></td>
              <td><?= htmlspecialchars($row['Start_Date']) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <div style="padding-bottom: 4rem"></div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
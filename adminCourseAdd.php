<?php
session_start();
require_once("config.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect post variables for adding course
    $courseNumber = $_POST['course_number'];
    $courseLocation = $_POST['course_location'];
    $courseName = $_POST['course_name'];
    $maxStudents = $_POST['max_students'];
    $instructorId = $_POST['instructor_id'];

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("CALL AddCourse(:course_number, :course_location, :course_name, :max_students, :instructor_id)");

        // Bind parameters
        $stmt->bindParam(':course_number', $courseNumber, PDO::PARAM_INT);
        $stmt->bindParam(':course_location', $courseLocation, PDO::PARAM_STR);
        $stmt->bindParam(':course_name', $courseName, PDO::PARAM_STR);
        $stmt->bindParam(':max_students', $maxStudents, PDO::PARAM_INT);
        $stmt->bindParam(':instructor_id', $instructorId, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        header('Location: adminViewEdit.php?status=success&entity=course');
    } catch (PDOException $e) {
        error_log("PDO Error: " . $e->getMessage());
        header('Location: adminViewEdit.php?status=error&entity=course');
    }

    $conn = null;
} else {
    header('Location: adminViewEdit.php?status=invalid_request');
}
?>

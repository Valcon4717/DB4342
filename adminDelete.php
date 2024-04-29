<?php
session_start();
require_once("config.php");

if (isset($_GET['Iid'])) {
    $instructorId = $_GET['Iid'];
    deleteInstructor($instructorId);
} elseif (isset($_GET['course_number']) && isset($_GET['course_location'])) {
    $courseNumber = $_GET['course_number'];
    $courseLocation = $_GET['course_location'];
    deleteCourse($courseNumber, $courseLocation);
} else {
    header('Location: adminViewEdit.php?status=invalid_request');
}

function deleteInstructor($instructorId) {
    global $host, $db, $username, $password;
    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("CALL DeleteInstructor(:Iid)");
        $stmt->bindParam(':Iid', $instructorId, PDO::PARAM_INT);
        $stmt->execute();

        header('Location: adminViewEdit.php?status=success&deleted=instructor');
    } catch(PDOException $e) {
        error_log("PDO Error: " . $e->getMessage());
        die("Error: " . $e->getMessage());
    } finally {
        $conn = null;
    }
}

function deleteCourse($courseNumber, $courseLocation) {
    global $host, $db, $username, $password;
    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("CALL DeleteCourse(:course_number, :course_location)");
        $stmt->bindParam(':course_number', $courseNumber, PDO::PARAM_INT);
        $stmt->bindParam(':course_location', $courseLocation, PDO::PARAM_STR);
        $stmt->execute();

        header('Location: adminViewEdit.php?status=success&deleted=course');
    } catch(PDOException $e) {
        error_log("PDO Error: " . $e->getMessage());
        die("Error: " . $e->getMessage());
    } finally {
        $conn = null;
    }
}
?>

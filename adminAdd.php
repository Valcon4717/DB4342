<?php
session_start();
require_once("config.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect post variables
    $instructorId = $_POST['instructor_id'];
    $instructorType = $_POST['instructor_type'];
    $seniorityLength = $_POST['seniority_length'];
    $gender = $_POST['gender'];
    $emailAddress = $_POST['email_address'];
    $phoneNumber = $_POST['phone_number'];
    $firstName = $_POST['first_name'];
    $middleName = $_POST['middle_name']; // Assuming middle name can be optional
    $lastName = $_POST['last_name'];
    $dob = $_POST['dob']; // Date of birth

    try {
        $conn = new PDO("mysql:host=$host;dbname=$db", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("CALL addInstructor(:instructor_id, :instructor_type, :seniority_length, :gender, :email_address, :phone_number, :first_name, :middle_name, :last_name, :dob)");
        
        // Bind parameters
        $stmt->bindParam(':instructor_id', $instructorId, PDO::PARAM_INT);
        $stmt->bindParam(':instructor_type', $instructorType, PDO::PARAM_STR);
        $stmt->bindParam(':seniority_length', $seniorityLength, PDO::PARAM_INT);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':email_address', $emailAddress, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':middle_name', $middleName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':dob', $dob);
        
        // Execute the query
        $stmt->execute();
        
        header('Location: adminViewEdit.php?status=success');
    } catch(PDOException $e) {
        error_log("PDO Error: " . $e->getMessage());
        header('Location: adminViewEdit.php?status=error');
    }
    
    $conn = null;
} else {
    header('Location: adminViewEdit.php?status=invalid_request');
}
?>

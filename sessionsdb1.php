<?php
require 'config.php';

// Retrieve data from POST
$date_time = $_POST['date_time']; // Rename this variable to match the column name
$treatment = $_POST['treatment'];
$doctor = $_POST['doctor'];
$priscription = $_POST['priscription'];
$status = $_POST['status'];

// Using prepared statements to prevent SQL injection
$sql = "INSERT INTO sessions (`date_time`, treatment, doctor, priscription, status)
            VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $date_time, $treatment, $doctor, $priscription, $status);

if ($stmt->execute()) {
    echo '<script>alert("New record created successfully"); window.location.href = "view_patient_details.php";</script>';
} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>
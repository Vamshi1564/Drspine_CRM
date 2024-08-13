<?php
require 'config.php';

if (isset($_POST['popup_id'])&&isset($_POST['patient_id'])) {
    $id = $_POST['popup_id'];
   
    $patient_id = $_POST['patient_id'];
    echo '<script>alert("'.$patient_id.'-----'.$id.'");</script>';
// Retrieve data from POST

$branch_name = $_POST['popup_branch_name'];
$appointment_number = $_POST['popup_appointment_number'];
$date_time = $_POST['date_time']; // Rename this variable to match the column name
$treatment = $_POST['treatment'];
$doctor = $_POST['popup_doctor_name'];
$priscription = $_POST['priscription'];
$status = $_POST['status'];


// Using prepared statements to prevent SQL injection
$sql = "INSERT INTO sessions (patient_id, appointment_number, date_time, treatment, doctor, priscription, status) VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $patient_id, $appointment_number, $date_time, $treatment, $doctor, $priscription, $status);

if ($stmt->execute()) {
    echo '<script>alert("Data inserted successfully.");</script>';
    echo '<script>window.location.href = "view_single_patient_details.php?patient_id=' . $patient_id . '&branch_name=' . $branch_name . '&doctor=' . $doctor . '";</script>';


} else {
    echo '<script>alert("Error inserting data: ' . $stmt->error . '");</script>';
}


// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
}
?>
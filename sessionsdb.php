<?php
require 'config.php';

if (isset($_POST['popup_id']) && isset($_POST['patient_id'])) {
    $id = $_POST['popup_id'];
    $patient_id = $_POST['patient_id'];

    // Retrieve data from POST
    $branch_name = $_POST['popup_branch_name'];
    $appointment_number = $_POST['popup_appointment_number'];
    $date_time = $_POST['date_time'];
    $treatment = $_POST['treatment'];
    $doctor = $_POST['popup_doctor_name'];
    $session_no = $_POST['session_no'];
    $status = $_POST['status'];

    // Check if time_from and time_to are set, otherwise set default values or handle as needed
$time_from = isset($_POST['popup_time_from']) ? $_POST['popup_time_from'] : 'default_time_from';
$time_to = isset($_POST['popup_time_to']) ? $_POST['popup_time_to'] : 'default_time_to';


    // Count the number of sessions for the patient and appointment_number
    // $sqlCount = "SELECT COUNT(session_no) AS session_count FROM sessions WHERE patient_id = ? AND appointment_number = ?";
    // $stmtCount = $conn->prepare($sqlCount);
    // $stmtCount->bind_param("ss", $patient_id, $appointment_number);
    // $stmtCount->execute();
    // $resultCount = $stmtCount->get_result();
    // $row = $resultCount->fetch_assoc();
    // $session_count = $row['session_count'] + 1; // Increment session count by 1

    // if ($row['session_count'] > 0) {
    //     $session_no = "session_no_" . $session_count;
    // } else {
    //     $session_no = "session_no_1";
    // }

    $sqlInsert = "INSERT INTO sessions (patient_id, session_no, appointment_number, date_time, treatment, time_from, time_to, doctor, status, branch_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($sqlInsert);
    $stmtInsert->bind_param("ssssssssss", $patient_id, $session_no, $appointment_number, $date_time, $treatment, $time_from, $time_to, $doctor, $status, $branch_name);
    
    if ($stmtInsert->execute()) {
        echo '<script>alert("Data inserted successfully.");</script>';
        echo '<script>window.location.href = "view_single_patient_details.php?patient_id=' . $patient_id . '&branch_name=' . $branch_name . '&doctor=' . $doctor . '";</script>';
    } else {
        echo '<script>alert("Error inserting data: ' . $stmtInsert->error . '");</script>';
    }

    // Close the prepared statements and the database connection
    $stmtCount->close();
    $stmtInsert->close();
    $conn->close();
}
?>

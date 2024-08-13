<?php
// Database configuration
require 'config.php';

// Handle the POST request to update the appointment details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $appointmentId = isset($_POST["id"]) ? $_POST["id"] : "";
    $doctorName = isset($_POST["doctor_name"]) ? $_POST["doctor_name"] : "";
    $appointmentDateTime = isset($_POST["appointment_date_time"]) ? $_POST["appointment_date_time"] : "";
    $durationMinutes = isset($_POST["duration_minutes"]) ? $_POST["duration_minutes"] : "";
    $reasonForAppointment = isset($_POST["reason_for_appointment"]) ? $_POST["reason_for_appointment"] : "";
    $patientFirstName = isset($_POST["patient_first_name"]) ? $_POST["patient_first_name"] : "";
    $patientLastName = isset($_POST["patient_last_name"]) ? $_POST["patient_last_name"] : "";

    // Update the appointment details
    $updateQuery = "UPDATE drspine_appointment
    SET doctor_name = '$doctorName',
        appointment_date_time = '$appointmentDateTime',
        duration_minutes = '$durationMinutes',
        reason_for_appointment = '$reasonForAppointment',
        patient_first_name = '$patientFirstName',
        patient_last_name = '$patientLastName'
    WHERE id = '$appointmentId'";

    if ($conn->query($updateQuery) === TRUE) {
        $response = ["success" => true];
    } else {
        $response = ["success" => false, "error" => $conn->error];
    }

    header("Content-Type: application/json");
    echo json_encode($response);
}

$conn->close();

?>

<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
   

require 'config.php';
// Include your database connection code here, e.g., require_once("db_connection.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "GET") {
// Get the appointment ID from the query string
$appointmentId = $_GET["id"];

// Query the database to fetch appointment data (customize this query)
$query = "SELECT appointment_date_time, doctor_name, patient_first_name, patient_middle_name, patient_last_name, contact_no, email_address, gender, date_of_birth, referred_by, refer_patient_type, refer_patient_name, reason_for_appointment, branch_name FROM drspine_appointment WHERE id = $appointmentId";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Return appointment data as JSON
    //echo json_encode($row);
} else {
    // Handle the case when no appointment is found
    echo json_encode(array("error" => "Appointment not found"));
}

// Close the database connection
$conn->close();
}

?>
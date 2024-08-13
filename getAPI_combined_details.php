<?php
// Database configuration
require 'config.php';
// Inside your PHP script
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log PHP errors to a file
ini_set('log_errors', 1);
//ini_set('error_log', '/path/to/php_error.log');

//$allowedOrigin = "http://localhost/drspine_crm_apnt/";
$allowedOrigin = "https://www.drspinecrm.in/drspine-CRM";
// Check if the request origin is allowed
header("Access-Control-Allow-Origin: " . $allowedOrigin);
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight requests (OPTIONS)
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204); // No content for preflight requests
    exit;
}

// Define the API endpoint URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Fetch appointments from the database
    $branch_name = isset($_GET["branch_name"]) ? $_GET["branch_name"] : "";
    $queryAppointments = "SELECT * FROM drspine_appointment WHERE branch_name='$branch_name'";
    $resultAppointments = $conn->query($queryAppointments);

    // Fetch sessions from the database
    // $querySessions = "SELECT * FROM sessions WHERE branch_name='$branch_name'";
    $querySessions = "SELECT DISTINCT s.*, p.patient_first_name, p.patient_middle_name, p.patient_last_name, p.patient_profile_picture, p.contact_no, p.email_address
FROM sessions s
JOIN drspine_appointment p ON s.patient_id = p.patient_id
WHERE s.branch_name='$branch_name'";


    $resultSessions = $conn->query($querySessions);

    if ($resultAppointments && $resultSessions) {
        $appointments = [];
        while ($row = $resultAppointments->fetch_assoc()) {
            $appointments[] = $row;
        }

        $sessions = [];
        while ($row = $resultSessions->fetch_assoc()) {
            $sessions[] = $row;
        }

        // Combine appointments and sessions into a single array
        $combinedData = ['appointments' => $appointments, 'sessions' => $sessions];

        header("Content-Type: application/json");
        echo json_encode($combinedData);

        $resultAppointments->free();
        $resultSessions->free();
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Failed to fetch data"]);
        // Add an alert message for debugging
        echo '<script>alert("Failed to fetch data from the database.");</script>';
    }
}

// Close the database connection
$conn->close();
?>

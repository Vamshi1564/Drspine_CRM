<?php
require 'config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204); // No content for preflight requests
    exit;
}

// Initialize the response array
$response = [
    "scheduleCount" => 0,
    "waitingCount" => 0,
    "engageCount" => 0,
    "doneCount" => 0,
    "presentCount" => 0
];

// Define the API endpoint URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $branch_name = isset($_GET["branch_name"]) ? $_GET["branch_name"] : "";

    // Count Schedule appointments
    $scheduleQuery = "SELECT COUNT(*) AS schedule_count FROM sessions 
                      WHERE DATE(date_time) = CURDATE() 
                      AND status = 'Scheduled' 
                      AND branch_name = '$branch_name'";
    $scheduleResult = $conn->query($scheduleQuery);

    if ($scheduleResult && $scheduleResult->num_rows > 0) {
        $scheduleRow = $scheduleResult->fetch_assoc();
        $response["scheduleCount"] = $scheduleRow['schedule_count'];
    }

    // Count Waiting appointments
    $waitingQuery = "SELECT COUNT(*) AS waiting_count FROM sessions 
                     WHERE DATE(date_time) = CURDATE() 
                     AND status = 'Waiting' 
                     AND branch_name = '$branch_name'";
    $waitingResult = $conn->query($waitingQuery);

    if ($waitingResult && $waitingResult->num_rows > 0) {
        $waitingRow = $waitingResult->fetch_assoc();
        $response["waitingCount"] = $waitingRow['waiting_count'];
    }

    // Count Engage appointments
    $engageQuery = "SELECT COUNT(*) AS engage_count FROM sessions 
                    WHERE DATE(date_time) = CURDATE() 
                    AND status = 'Engage' 
                    AND branch_name = '$branch_name'";
    $engageResult = $conn->query($engageQuery);

    if ($engageResult && $engageResult->num_rows > 0) {
        $engageRow = $engageResult->fetch_assoc();
        $response["engageCount"] = $engageRow['engage_count'];
    }

    // Count Done appointments
    $doneQuery = "SELECT COUNT(*) AS done_count FROM sessions 
                  WHERE DATE(date_time) = CURDATE() 
                  AND status = 'Done' 
                  AND branch_name = '$branch_name'";
    $doneResult = $conn->query($doneQuery);

    if ($doneResult && $doneResult->num_rows > 0) {
        $doneRow = $doneResult->fetch_assoc();
        $response["doneCount"] = $doneRow['done_count'];
    }

    // Count Present appointments
    $presentQuery = "SELECT COUNT(*) AS present_count FROM sessions 
                     WHERE DATE(date_time) = CURDATE() 
                     AND status = 'Present' 
                     AND branch_name = '$branch_name'";
    $presentResult = $conn->query($presentQuery);

    if ($presentResult && $presentResult->num_rows > 0) {
        $presentRow = $presentResult->fetch_assoc();
        $response["presentCount"] = $presentRow['present_count'];
    }

    // Execute the SQL query to get the appointments for today sorted by time
    $query = "SELECT DISTINCT s.*, p.patient_first_name, p.patient_middle_name, p.patient_last_name, p.patient_profile_picture, p.contact_no, p.email_address
              FROM sessions s
              JOIN drspine_appointment p ON s.patient_id = p.patient_id
              WHERE s.branch_name='$branch_name' and
              DATE(date_time) = CURDATE() 
                   
              ORDER BY TIME(s.date_time) ASC";
//    AND today_status = 'Present' 
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $sessions = [];
        while ($row = $result->fetch_assoc()) {
            $sessions[] = $row;
        }
        $response["results"] = $sessions;
    }
}

// Close the database connection
$conn->close();

// Set the response content type
header("Content-Type: application/json");

// Encode the response data as JSON and send it
echo json_encode($response);

?>

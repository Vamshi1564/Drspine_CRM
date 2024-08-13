<?php
// Database configuration
require 'config.php';

// Enable error reporting and set headers
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log PHP errors to a file
ini_set('log_errors', 1);

// $allowedOrigin = "http://localhost/drspine_crm_apnt/";

// // Check if the request origin is allowed
// header("Access-Control-Allow-Origin: " . $allowedOrigin);
// header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
// header("Access-Control-Allow-Headers: Content-Type");

// Handle preflight requests (OPTIONS)
if ($_SERVER["REQUEST_METHOD"] === "OPTIONS") {
    http_response_code(204); // No content for preflight requests
    exit;
}

// Initialize the response array
$response = [
    "scheduleCount" => 0, // Default count value for Schedule
    "waitingCount" => 0, // Default count value for Waiting
    "engageCount" => 0, // Default count value for Engage
    "doneCount" => 0,    // Default count value for Done
    "presentCount" => 0  // Default count value for Present
];

// Define the API endpoint URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $branch_name = isset($_GET["branch_name"]) ? $_GET["branch_name"] : "";

    // Count Schedule appointments
    $scheduleQuery = "SELECT COUNT(*) AS schedule_count FROM drspine_appointment 
                      WHERE DATE(appointment_date_time) = CURDATE() 
                      AND today_status = 'Schedule' 
                      AND branch_name = '$branch_name'";
    $scheduleResult = $conn->query($scheduleQuery);

    if ($scheduleResult && $scheduleResult->num_rows > 0) {
        $scheduleRow = $scheduleResult->fetch_assoc();
        $response["scheduleCount"] = $scheduleRow['schedule_count'];
    }

    // Count Waiting appointments
    $waitingQuery = "SELECT COUNT(*) AS waiting_count FROM drspine_appointment 
                     WHERE DATE(appointment_date_time) = CURDATE() 
                     AND today_status = 'Waiting' 
                     AND branch_name = '$branch_name'";
    $waitingResult = $conn->query($waitingQuery);

    if ($waitingResult && $waitingResult->num_rows > 0) {
        $waitingRow = $waitingResult->fetch_assoc();
        $response["waitingCount"] = $waitingRow['waiting_count'];
    }

    // Count Engage appointments
    $engageQuery = "SELECT COUNT(*) AS engage_count FROM drspine_appointment 
                    WHERE DATE(appointment_date_time) = CURDATE() 
                    AND today_status = 'Engage' 
                    AND branch_name = '$branch_name'";
    $engageResult = $conn->query($engageQuery);

    if ($engageResult && $engageResult->num_rows > 0) {
        $engageRow = $engageResult->fetch_assoc();
        $response["engageCount"] = $engageRow['engage_count'];
    }

    // Count Done appointments
    $doneQuery = "SELECT COUNT(*) AS done_count FROM drspine_appointment 
                  WHERE DATE(appointment_date_time) = CURDATE() 
                  AND today_status = 'Done' 
                  AND branch_name = '$branch_name'";
    $doneResult = $conn->query($doneQuery);

    if ($doneResult && $doneResult->num_rows > 0) {
        $doneRow = $doneResult->fetch_assoc();
        $response["doneCount"] = $doneRow['done_count'];
    }

    // Count Present appointments
    $presentQuery = "SELECT COUNT(*) AS present_count FROM drspine_appointment 
                     WHERE DATE(appointment_date_time) = CURDATE() 
                     AND today_status = 'Present' 
                     AND branch_name = '$branch_name'";
    $presentResult = $conn->query($presentQuery);

    if ($presentResult && $presentResult->num_rows > 0) {
        $presentRow = $presentResult->fetch_assoc();
        $response["presentCount"] = $presentRow['present_count'];
    }


// echo "<script>console.log('SQL Query: " . mysqli_real_escape_string($conn, $countQuery) . "');</script>";


 //echo "<script>alert('SQL Query: " . mysqli_real_escape_string($conn, $countQuery) . "');</script>";
   

    // Execute the SQL query to get the appointments for today sorted by time
    // $query = "SELECT * FROM drspine_appointment
    //           WHERE DATE(appointment_date_time) = CURDATE() and  branch_name='$branch_name'
    //           ORDER BY TIME(appointment_date_time) ASC";

    
    $query = "SELECT a.*, IFNULL(b.no_of_booked_appointments_patient_id, 0) as no_of_booked_appointments_patient_id
          FROM drspine_appointment a
          LEFT JOIN (
              SELECT patient_id, COUNT(*) as no_of_booked_appointments_patient_id
              FROM drspine_appointment
              WHERE DATE(appointment_date_time) = CURDATE() AND branch_name = '$branch_name'
              GROUP BY patient_id
          ) b ON a.patient_id = b.patient_id
          WHERE DATE(a.appointment_date_time) = CURDATE() AND a.branch_name = '$branch_name'
          ORDER BY TIME(a.appointment_date_time) ASC";


    // $query = "SELECT * FROM drspine_appointment
    //           WHERE DATE(appointment_date_time) = '2023-10-23' and  branch_name='whitefield'
    //           ORDER BY TIME(appointment_date_time) ASC";

              
// echo "<script>console.log('SQL Query: " . mysqli_real_escape_string($conn, $query) . "');</script>";


//echo "<script>alert('SQL Query: " . mysqli_real_escape_string($conn, $query) . "');</script>";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        $response["results"] = $appointments;
    }
}
// $patients_count_query = "SELECT * FROM drspine_appointment 
// WHERE  branch_name='whitefield'
// ";
// $patients_count_result = $conn->query($patients_count_query);

// if ($result && $result->num_rows > 0) {
//     $appointments = [];
//     $patientCounts = []; // Array to store appointment counts for each patient

//     while ($row = $result->fetch_assoc()) {

//         // Append the row to the $appointments array
//         $appointments[] = $row;
//     }
   

//     while ($patients_count_row = $patients_count_result->fetch_assoc()) {
//         $patientId = $patients_count_row['patient_id'];
        
//            if (!isset($patientCounts[$patientId])) {
//                $patientCounts[$patientId] = 0;
//            }
   
//            $patientCounts[$patientId]++;
   
//            // Add the count directly to the current $row
//            $patients_count_row['no_of_booked_appointments_patient_id'] = $patientCounts[$patientId];
   
//            // Append the row to the $appointments array
//            $appointments[] = $patients_count_row;
//     }
//     $response["results"] = $appointments;
    // Convert PHP variables to JSON for use in JavaScript
    // $appointmentsJSON = json_encode($appointments);
    // $responseJSON = json_encode($response);

    // // Output the values to the browser console
    // echo "<script>";
    // echo "console.log('Appointments:', " . $appointmentsJSON . ");";
    // echo "console.log('Response:', " . $responseJSON . ");";
    // echo "</script>";

    // // Show a pop-up alert with the values
    // echo "<script>";
    // echo "alert('Appointments: " . $appointmentsJSON . "');";
    // echo "alert('Response: " . $responseJSON . "');";
    // echo "</script>";




// Close the database connection
$conn->close();

// Set the response content type
header("Content-Type: application/json");

// Encode the response data as JSON and send it
echo json_encode($response);
?>

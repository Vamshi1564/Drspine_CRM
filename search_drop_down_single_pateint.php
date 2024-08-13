<?php
// Handle database connection and configuration here
// ...
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'config.php';

$response = [
    'success' => false,
    'message' => 'Error preparing SQL statement.'
];

if (isset($_GET['search'])) {
    $search = $_GET['search'];
    
   $sql = "SELECT DISTINCT a.*
   FROM drspine_appointment a
   JOIN (
       SELECT patient_id, MAX(appointment_date_time) as max_appointment_date_time
       FROM drspine_appointment
       GROUP BY patient_id
   ) b ON a.patient_id = b.patient_id AND a.appointment_date_time = b.max_appointment_date_time
   WHERE a.patient_first_name LIKE '%$search%' OR a.contact_no LIKE '%$search%';
   ";
    // Execute the SQL query
    $queryResult = mysqli_query($conn, $sql);

    if ($queryResult) {
        $results = [];

        while ($row = mysqli_fetch_assoc($queryResult)) {
            $results[] = $row;
        }

        $response = [
            'success' => true,
            'message' => 'Data retrieved successfully.',
            'data' => $results
        ];
    } else {
        $response['message'] = 'Error executing SQL query.';
    }
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

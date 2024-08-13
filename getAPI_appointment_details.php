<?php
// Database configuration
require 'config.php';
// Inside your PHP script
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log PHP errors to a file
ini_set('log_errors', 1);
//ini_set('error_log', '/path/to/php_error.log');

$allowedOrigin = "http://localhost/drspine_crm_apnt/";

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
    //$branch_name=$_GET["branch_name"];
    $branch_name = isset($_GET["branch_name"]) ? $_GET["branch_name"] : "";
    $query = "SELECT * FROM drspine_appointment where branch_name='$branch_name'";
    $result = $conn->query($query);
    
    if ($result) {
        $appointments = [];
        while ($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
        header("Content-Type: application/json");
        echo json_encode($appointments);
        $result->free();

        
        // Log the data to the console for debugging
       // echo '<script>console.log(' . json_encode($appointments) . ');</script>';
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Failed to fetch appointments"]);

        // Add an alert message for debugging
        echo '<script>alert("Failed to fetch appointments from the database.");</script>';
    }
}

// Close the database connection
$conn->close();
?>

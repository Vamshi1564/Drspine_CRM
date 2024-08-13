<?php
// Database configuration
require 'config.php'; // Include your database connection configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the appointment ID and new start time from the POST request
    $sessionId = $_POST['id'];
    $newStartTime = $_POST['newStartTime'];

    // Update the appointment time in the database
    $query = "UPDATE sessions SET date_time = ? WHERE id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        // Bind the parameters
        $stmt->bind_param("si", $newStartTime, $sessionId);

        // Execute the query
        if ($stmt->execute()) {
            // Appointment time updated successfully
            echo json_encode(["message" => "Session time updated successfully"]);
        } else {
            // Error updating the appointment time
            http_response_code(500); // Internal Server Error
            echo json_encode(["error" => "Failed to update session time"]);
        }

        // Close the statement
        $stmt->close();
    } else {
        // Error in prepared statement
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Error in prepared statement"]);
    }
} else {
    // Invalid request method
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Invalid request method"]);
}

// Close the database connection
$conn->close();
?>

<?php
// Database configuration
// require 'config.php'; // Include your database configuration

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     // Get the new start and end times from the POST data
//     $newStartTime = $_POST['newStartTime'];
//     $newEndTime = $_POST['newEndTime'];
//     $eventId = $_POST['eventId']; // Assuming you have an event ID to identify the appointment

//     // Update the appointment time in the database
//     $query = "UPDATE drspine_appointment SET appointment_date_time = ?, end_datetime = ? WHERE id = ?";
//     $stmt = $mysqli->prepare($query);
//     $stmt->bind_param("ssi", $newStartTime, $newEndTime, $eventId);

//     if ($stmt->execute()) {
//         // Appointment time updated successfully
//         echo json_encode(["success" => true]);
//     } else {
//         // Error updating appointment time
//         http_response_code(500); // Internal Server Error
//         echo json_encode(["error" => "Failed to update appointment time"]);
//     }

//     $stmt->close();
// }

// // Close the database connection
// $mysqli->close();
?>


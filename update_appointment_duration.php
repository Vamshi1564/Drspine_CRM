<?php
// Include your database connection code here, e.g., require_once("db_connection.php");
require 'config.php';
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the data from the POST request
   // echo '<script>console.log("you are dragging the appoinment shedule time ");</script>';
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $newDurationMinutes = isset($_POST['duration_minutes']) ? $_POST['duration_minutes'] : null;
    
    if ($id !== null && $newDurationMinutes !== null) {
        // Prepare the SQL query to update duration_minutes
        $query = "UPDATE drspine_appointment SET duration_minutes = ? WHERE id = ?";

        // Prepare and bind the SQL statement
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ii", $newDurationMinutes, $id);

            // Execute the statement
            if ($stmt->execute()) {
                $response = [
                    'success' => true,
                    'message' => 'Duration minutes updated successfully.'
                ];
                echo json_encode($response);
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Failed to update duration minutes.'
                ];
                echo json_encode($response);
            }

            // Close the statement
            $stmt->close();
        } else {
            $response = [
                'success' => false,
                'message' => 'Error preparing SQL statement.'
            ];
            echo json_encode($response);
        }
    } else {
        $response = [
            'success' => false,
            'message' => 'Invalid or missing parameters.'
        ];
        echo json_encode($response);
    }
} else {
    $response = [
        'success' => false,
        'message' => 'Invalid request method.'
    ];
    echo json_encode($response);
}

// Close the database connection
$conn->close();
?>

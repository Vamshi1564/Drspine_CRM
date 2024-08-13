<?php
// Replace with your actual database credentials
require "config.php";

// Get the event ID from the request
if (isset($_GET['id'])) {
    $eventId = $_GET['id'];
    
    // Query to fetch event details from the drspine_appointment table
    $query = "SELECT * FROM drspine_appointment WHERE id = $eventId";

    // Execute the query
    $result = $conn->query($query);

    if ($result) {
        // Fetch the data as an associative array
        $row = $result->fetch_assoc();

        // Check if the event with the specified ID was found
        if ($row) {
            // Return the data as JSON
            header('Content-Type: application/json');
            echo json_encode($row);
        } else {
            // Return a message if the event was not found
            echo json_encode(['error' => 'Event not found']);
        }
        
        // Free the result set
        $result->free();
    } else {
        // Return an error message if the query fails
        echo json_encode(['error' => 'Query failed']);
    }

    // Close the database connection
    $conn->close();
} else {
    // Return an error message if the 'id' parameter is not set
    echo json_encode(['error' => 'Event ID not specified']);
}
?>

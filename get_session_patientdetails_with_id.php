<?php
// Replace with your actual database credentials
require "config.php";

// Get the session ID from the request
if (isset($_GET['id'])) {
    $sessionId = $_GET['id'];

    // Using prepared statements to prevent SQL injection
    $query = "SELECT * FROM sessions WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sessionId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        // Fetch the data as an associative array
        $row = $result->fetch_assoc();

        // Check if the session with the specified ID was found
        if ($row) {
            // Return the data as JSON
            header('Content-Type: application/json');
            echo json_encode($row);
        } else {
            // Return a message if the session was not found
            echo json_encode(['error' => 'Session not found']);
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        // Return an error message if the query fails
        echo json_encode(['error' => 'Query failed']);
    }

    // Close the database connection
    $conn->close();
} else {
    // Return an error message if the 'id' parameter is not set
    echo json_encode(['error' => 'Session ID not specified']);
}
?>

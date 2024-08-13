<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include("config.php");

if (isset($_GET['Id'])) {
    $sessionsId = $_GET['Id'];

    // Fetch session details from the database
    $sql = "SELECT * FROM sessions WHERE id = $sessionsId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $sessionDetails = $result->fetch_assoc(); // Fetch session details

        // echo "<h3>Session Details</h3>";
        // echo "<p><strong>Date&Time:</strong> " . $sessionDetails['date_time'] . "</p>";
        // echo "<p><strong>Treatment:</strong> " . $sessionDetails['treatment'] . "</p>";
        // echo "<p><strong>Doctor:</strong> " . $sessionDetails['doctor'] . "</p>";
        // echo "<p><strong>Prescription:</strong> " . $sessionDetails['prescription'] . "</p>";
        // echo "<p><strong>Status:</strong> " . $sessionDetails['status'] . "</p>";
    } 
    // else {
    //     echo "Session not found in the database.";
    // }
} 
else {
    echo "Invalid session ID.";
}

$conn->close();
?>

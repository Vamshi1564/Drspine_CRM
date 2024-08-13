<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
} else {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
}

include("config.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    try {
        // Validate and sanitize input
        $id = isset($_GET["patient_id"]) ? intval($_GET["patient_id"]) : 0;

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("DELETE FROM drspine_appointment WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $response = ["success" => true, "message" => "Appointment Deleted Successfully"];
        } else {
            $response = ["success" => false, "message" => "Failed to delete the Appointment, try again!!!"];
        }

        $stmt->close();
    } catch (Exception $e) {
        $response = ["success" => false, "message" => "An error occurred: " . $e->getMessage()];
    }
}

$conn->close();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

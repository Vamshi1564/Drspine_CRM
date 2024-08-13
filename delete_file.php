<?php
session_start();
include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the CSRF token is valid
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        http_response_code(403);  // Forbidden
        echo json_encode(['success' => false, 'message' => 'CSRF token mismatch']);
        exit;
    }

    // Sanitize and validate the file ID
    if (!isset($_POST['file_id']) || !ctype_digit($_POST['file_id'])) {
        http_response_code(400);  // Bad Request
        echo json_encode(['success' => false, 'message' => 'Invalid file ID']);
        exit;
    }
    $fileId = intval($_POST['file_id']);

    // Delete the file from the database
    $sql = "DELETE FROM patient_docs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $fileId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'File deleted successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Database delete failed']);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(405);  // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>

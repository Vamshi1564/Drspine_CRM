<?php
// Include your database connection configuration
include("config.php");

if (isset($_GET['file_id'])) {
    $fileId = $_GET['file_id'];

    // Retrieve file data based on the file ID
    $sql = "SELECT file_data, mime_type FROM patient_docs WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $fileId);
    $stmt->execute();
    $stmt->bind_result($fileData, $mimeType);

    if ($stmt->fetch()) {
        // Set appropriate headers for the file type
        header('Content-Type: ' . $mimeType);
         // You can set the filename based on your needs
        header('Content-Type: application/pdf');

        // Output the file data
        echo $fileData;
    } else {
        // File not found
        header("HTTP/1.0 404 Not Found");
        echo "File not found";
    }

    $stmt->close();
    $conn->close();
} else {
    // Invalid request
    header("HTTP/1.0 400 Bad Request");
    echo "Bad Request";
}
?>

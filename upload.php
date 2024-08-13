<?php
include("config.php");

$patient_id = $_GET['patient_id'] ?? '';
$branch_name = $_GET['branch_name'] ?? '';

// Allowed file types for validation
$allowedFileTypes = ['pdf', 'doc', 'docx', 'zip', 'jpg', 'jpeg', 'png'];

// Check if file is uploaded
if (isset($_FILES['fileToUpload'])) {
    $file = $_FILES['fileToUpload'];

    // Check for file upload errors
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $fileTmpName = $file['tmp_name'];
        $comments = $_POST['comments'] ?? '';

        // Validate file type
        if (in_array($fileType, $allowedFileTypes)) {
            // Sanitize the file name to remove special characters
            $safeFileName = preg_replace('/[^\w\-\.]/', '_', $fileName);

            // Create the directory if it doesn't exist
            $uploadDir = "patient_docus/$patient_id/";
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Generate a unique file path
            $filePath = $uploadDir . $safeFileName;

            // Move the file to the patient_docus directory
            if (move_uploaded_file($fileTmpName, $filePath)) {
                // Insert file data into the database
                $sql = "INSERT INTO patient_docs (patient_id, filename, mime_type, comments, timestamp, file_path)
                        VALUES (?, ?, ?, ?, NOW(), ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssss", $patient_id, $safeFileName, $fileType, $comments, $filePath);
                $stmt->execute();
                $stmt->close();

                $alertMessage = "File uploaded successfully.";
            } else {
                $alertMessage = "Failed to move uploaded file.";
            }
        } else {
            $alertMessage = "Invalid file type. Allowed types: pdf, doc, docx, zip, jpg, jpeg, png.";
        }
    } else {
        $alertMessage = "Error in file upload. Please try again.";
    }

    // Echo the JavaScript for the alert and redirection
    echo "<script>
            alert('".$alertMessage."');
            window.location.href = 'view_single_patient_details.php?patient_id=".$patient_id."&branch_name=".$branch_name."';
          </script>";
}

$conn->close();
?>

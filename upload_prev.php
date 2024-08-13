<?php
  include("config.php");
  ?>


<?php

// Get the patient ID from the URL parameter
if (isset($_GET['patient_id'])) {
    $patient_id = $_GET['patient_id'];
} else {
    // Handle case where patient ID is not provided
    echo "Patient ID not provided.";
    exit();
}

if (isset($_FILES['fileToUpload'])) {
    $file = $_FILES['fileToUpload'];

    $fileName = $file['name'];
    $fileType = $file['type'];
    $fileTmpName = $file['tmp_name'];

    // Read the file into binary data
    $fileData = file_get_contents($fileTmpName);

    // Insert file data, metadata, and patient ID into the database
    $sql = "INSERT INTO prev_patients_docs (patient_id, filename, mime_type, file_data)
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $patient_id, $fileName, $fileType, $fileData);
    $stmt->execute();
    $stmt->close();
    

     // Upload success message
     $message = "File uploaded successfully.";
    } else {
        // Handle case where no file is uploaded
        $message = "No file uploaded.";
    }


// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload Result</title>
    <script>
        // Display a popup alert with the message
        window.onload = function() {
            var message = "<?php echo $message; ?>";
            alert(message);
          
        };
    </script>
</head>
<body>
    <p>Redirecting back to the previous page...</p>
    <script>
        // After showing the alert, redirect back to the previous page
        setTimeout(function() {
            history.go(-1);
        }, 3000); // Redirect after 3 seconds
    </script>
</body>
</html>

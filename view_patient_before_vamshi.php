<?php
include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
</head>
<body>
<?php

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Fetch patient details using $patient_id
    $sql = "SELECT * FROM appointments WHERE id = $id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $eventDetails = $result->fetch_assoc();
        echo "<h3>Patient Details</h3>";
        echo "<h3>Appointment Details</h3>";
        echo "<p><strong>Name:</strong> " . $eventDetails['name'] . "</p>";
        echo "<p><strong>Patient Id:</strong> " . $eventDetails['patient_id'] . "</p>";
        echo "<p><strong>Date:</strong> " . $eventDetails['date'] . "</p>";
        echo "<p><strong>Time:</strong> " . $eventDetails['time'] . "</p>";
        echo "<p><strong>Email:</strong> " . $eventDetails['email'] . "</p>";
        echo "<p><strong>No Of Session:</strong> " . $eventDetails['no_of_session'] . "</p>";
        echo "<p><strong>Mobile:</strong> " . $eventDetails['mobile'] . "</p>";
        echo "<p><strong>Doctor:</strong> " . $eventDetails['doctor'] . "</p>";
        echo "<p><strong>City:</strong> " . $eventDetails['city'] . "</p>";
        echo "<p><strong>Issue:</strong> " . $eventDetails['issue'] . "</p>";
    } else {
        // Handle case where no patient found
        echo "Patient not found.";
        exit();
    }
} else {
    // Handle case where no patient ID is provided
    echo "Patient ID not provided.";
    exit();
}
// Connection established successfully
echo "Connected to the database: $dbname";
?>

   
</body>
</html>
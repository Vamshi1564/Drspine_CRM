<?php
  include("config.php");
  ?>


<?php

// Retrieve data from POST
$patient_id = $_POST['patient_id'];
$pname = $_POST['pname'];
$gender = $_POST['gender'];
$dob = $_POST['dob'];
$occupation = $_POST['occupation'];
$age = $_POST['age'];
$email = $_POST['email'];
$date = $_POST['date'];
$contact_number = $_POST['contact_number'];
$location = $_POST['location'];
$city = $_POST['city'];
$source = $_POST['source'];
$session_plans = $_POST['session_plans'];

// Handle multiple selected treatments
$treatment = implode(", ", $_POST['selected_treatments']); // Combine selected treatments into a comma-separated string


// Using prepared statements to prevent SQL injection
$sql = "INSERT INTO patients (patient_id, pname, gender, dob, occupation, age, email, date, contact_number, location, city, source, treatment, session_plans) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssssss", $patient_id, $pname, $gender, $dob, $occupation, $age, $email, $date, $contact_number, $location, $city, $source, $treatment, $session_plans);

if ($stmt->execute()) {
    echo '<script>alert("New record created successfully"); window.location.href = "view-patients.php";</script>';
} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>

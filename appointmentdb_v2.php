<?php
require 'config.php';
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the $_POST array
    $patientId = $_POST["patient_id"];
    $name = $_POST["name"];
    $dateOfBirth = $_POST["date_of_birth"];
    $age = $_POST["age"];
    $email = $_POST["email"];
    $mobile = $_POST["mobile"];
    $gender = $_POST["gender"];
    $occupation = $_POST["occupation"];
    $address = $_POST["address"];
    $doctor = $_POST["doctor"];
    $issue = $_POST["issue"];
    $date = $_POST["date"];
    $timeFrom = $_POST["time_from"];
    $timeTo = $_POST["time_to"];
    $paymentStatus = $_POST["payment_status"];
    echo '<script>alert("' .$mobile. '");</script>';
    
   
    // Insert data into the appointments table
    $sql = "INSERT INTO appointments (patient_id, name, date_of_birth, age, email, mobile, gender, occupation, address, doctor, issue, date, time_from, time_to, payment_status)
            VALUES ('$patientId', '$name', '$dateOfBirth', $age, '$email', '$mobile', '$gender', '$occupation', '$address', '$doctor', '$issue', '$date', '$timeFrom', '$timeTo', '$paymentStatus')";

$stmt = $conn->prepare($sql);
// $stmt->bind_param("ssssssssss", $name,  $patient_id, $date,  $time, $age, $occupation, $email, $no_of_session, $mobile, $doctor, $city, $issue ,$payment_status, $gender ); // Corrected binding types

if ($stmt->execute()) {
    echo '<script>alert("New record created successfully"); window.location.href = "appointment_list.php";</script>';
} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
}
?>
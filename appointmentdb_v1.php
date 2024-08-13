<?php
// Assuming your database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cmr_demo(1)";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from POST

// Retrieve data from POST
$name = $_POST['name'];
$patient_id = $_POST['patient_id']; // Corrected field name
$date = $_POST['date'];
$time = $_POST['time'];
$age = $_POST['age'];
$occupation = $_POST['occupation'];

$email = $_POST['email'];
$no_of_session = $_POST['no_of_session'];
$mobile = $_POST['mobile'];
$doctor = $_POST['doctor'];
$city= $_POST['city'];
$issue= $_POST['issue'];
$payment_status= $_POST['payment_status'];
$gender= $_POST['gender'];
// Using prepared statements to prevent SQL injection
$sql = "INSERT INTO appointments (name, patient_id, date, time, age, occupation, email, no_of_session, mobile, doctor, city, issue, payment_status, gender)
            VALUES ('$name', '$patient_id', '$date', '$time', '$age', '$occupation', '$email', '$no_of_session', '$mobile', '$doctor', '$city', '$issue', '$payment_status', '$gender')";

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

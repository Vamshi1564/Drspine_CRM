<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include("config.php");

if (isset($_GET['Id'])) {
    $appointmentId = $_GET['Id'];

    $sql = "SELECT * FROM appointments WHERE id = $appointmentId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $appointmentDetails = $result->fetch_assoc();

        echo "<h3>Appointment Details</h3>";
        echo "<p><strong>Name:</strong> " . $appointmentDetails['name'] . "</p>";
        echo "<p><strong>Patient Id:</strong> " . $appointmentDetails['patient_id'] . "</p>";
        echo "<p><strong>Date:</strong> " . $appointmentDetails['date'] . "</p>";
        echo "<p><strong>Time:</strong> " . $appointmentDetails['time_from'] . " To ".$appointmentDetails['time_to']."</p>";

        echo "<p><strong>Email:</strong> " . $appointmentDetails['email'] . "</p>";
        // echo "<p><strong>No Of Session:</strong> " . $appointmentDetails['no_of_session'] . "</p>";
        echo "<p><strong>Mobile:</strong> " . $appointmentDetails['mobile'] . "</p>";
        echo "<p><strong>Doctor:</strong> " . $appointmentDetails['doctor'] . "</p>";
        // echo "<p><strong>City:</strong> " . $eventDetails['city'] . "</p>";
        // echo "<p><strong>Issue:</strong> " . $eventDetails['issue'] . "</p>";
        echo "<a class='view-details-button' href='view_patient_details.php?id=" . $appointmentDetails['id'] . "'>View Details</a>";
    } else {
        echo "Appointment not found.";
    }
} else {
    echo "Invalid appointment ID.";
}

$conn->close();
?>
<style>
    .view-details-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    /* .view-details-button:hover {
        background-color: #0056b3;
    } */
</style>
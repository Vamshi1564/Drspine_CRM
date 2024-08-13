<?php
include("config.php");
// Ensure that the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve data from the form
  $patient_first_name = $_POST['patient_first_name'];
    $patient_middle_name = $_POST['patient_middle_name'];
    $patient_last_name = $_POST['patient_last_name'];
  
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $contact_no = $_POST['contact_no'];
    $patient_address = $_POST['patient_address'];
    $email_address = $_POST['email_address'];

    // Ensure the patient_id is available
    if (isset($_GET['patient_id'])) {
        $patient_id = $_GET['patient_id'];
$branch_name =  $_GET['branch_name'];
        // Update the patient details in the database
        $sql = "UPDATE drspine_appointment SET 
        
        patient_first_name = ?, 
                patient_middle_name = ?, 
                patient_last_name = ?,
        
                date_of_birth = ?,
                gender = ?,
                contact_no = ?,
                patient_address = ?,
                email_address = ?
                WHERE patient_id = ?";

        $stmt = $conn->prepare($sql);
      
        $stmt->bind_param("ssssssssi", $patient_first_name, $patient_middle_name, $patient_last_name, $date_of_birth, $gender, $contact_no, $patient_address, $email_address, $patient_id);

        if ($stmt->execute()) {
            // Alert the user that patient details are updated
            echo '<script>alert("Patient details updated successfully.");';
            echo 'window.location.href = "view_single_patient_details.php?patient_id='.$patient_id.'&branch_name='.$branch_name.'";</script>';
        } else {
            echo '<script>alert("Error updating patient details: ' . $stmt->error . '");</script>';
        }
        
        // Close the prepared statement and the database connection
        $stmt->close();
        $conn->close();
        
    } else {
        echo "Patient ID not provided.";
    }
} else {
    echo "Invalid request.";
}

?>
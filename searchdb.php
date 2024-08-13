<?php
error_reporting(E_ALL);
include("config.php");

if (isset($_POST['search_btn'])) {
    $search = trim($_POST['search']);

    // Check if branch_name is set, and use prepared statement
    if (isset($_POST['branch_name'])) {
        $branch_name = $_POST['branch_name'];

        $sql = "SELECT * FROM drspine_appointment WHERE patient_id = ? OR email_address = ? OR contact_no = ? AND branch_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $search, $search, $search, $branch_name);
    } else {
        $sql = "SELECT * FROM drspine_appointment WHERE patient_id = ? OR email_address = ? OR contact_no = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $search, $search, $search);
    }

    // Display the SQL query in the browser's console
    echo "<script>console.log('SQL Query: " . $sql . "');</script>";

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        header("Location: view_single_patient_details.php?patient_id={$patient['patient_id']}&branch_name={$patient['branch_name']}");
        exit();
    } else {
        // Handle case where no patient found
        echo '<script>alert("Patient not found")</script>';
        header("Location: patient_details.php");
        exit();
    }
}
?>

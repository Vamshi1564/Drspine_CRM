<?php
// fetch_doctors.php
require 'config.php';
// Check if branch_name is provided via GET request
if (isset($_GET['branch_name'])) {
    // Get the branch_name from the GET request
    $branchName = $_GET['branch_name'];

    // Prepare and execute a query to fetch doctors based on branch_name
    $query = "SELECT id, doctor_name FROM doctor WHERE branch_name = '$branchName'";
    $result = $conn->query($query);

    if ($result) {
        $doctors = [];

        // Fetch the results as an associative array
        while ($row = $result->fetch_assoc()) {
            $doctors[] = $row;
        }

        // Close the database connection
        $conn->close();

        // Create a response array
        $response = ['success' => true, 'doctors' => $doctors];

        // Send the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // If there's an error with the query
        $response = ['success' => false, 'message' => 'Query error: ' . $conn->error];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
} else {
    // If branch_name is not provided in the GET request
    $response = ['success' => false, 'message' => 'Branch name not provided'];
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>

<?php
require 'config.php';
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the 'cancelled_by' and 'reason_for_cancel' values from the POST request
    $id=$_POST['id'];
    $branch_name = $_POST['branch_name'];
    $cancelledBy = $_POST['cancelled_by'];
    $reasonForCancel = $_POST['reason_for_cancel'];
    

    $sql = "UPDATE drspine_appointment SET `today_status` = '$cancelledBy', `cancelled_by` = '$cancelledBy', `reason_for_cancel` = '$reasonForCancel' WHERE id = $id";


    if (mysqli_query($conn, $sql)) {
        //$response = "Update successful"; // Set the response message
       
//         echo '<script>alert("Appointment cancelled successfully"); 
// window.location.href = "app_calender.php?branch_name=' . $branch_name . '";</script>';
        $response = ["success" => true];
    } else {
       // $response = "Error: " . $sql . "<br>" . mysqli_error($conn); // Set an error response
       $response = ["success" => false, "error" => $conn->error];
    }

    // Close the database connection
    mysqli_close($conn);

    // Set the response content type
    header("Content-Type: application/json");

    // Encode and send the response as JSON
    echo json_encode($response);
} else {
    http_response_code(405); // Method Not Allowed
    echo "Invalid request method";
}

<?php
// Include your database connection code here
//echo '<script>alert("beofee resposne array into slect chnage for stuats");</script>';
$response = array(); // Create an array to hold the response data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rowId = $_POST["id"];
    $newStatus = $_POST["status"];
    echo '<script>alert("entered into slect chnage for stuats");</script>';
    // Perform the database update for the status
    // Use prepared statements to prevent SQL injection

    // Example using mysqli:
    $stmt = $mysqli->prepare("UPDATE appointments SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $newStatus, $rowId);
    
    if ($stmt->execute()) {
        // Update was successful
        $response['success'] = true;
        $response['message'] = "Status updated successfully";
    } else {
        // Update failed
        $response['success'] = false;
        $response['message'] = "Error updating status: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>

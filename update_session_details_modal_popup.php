<?php
// Database configuration
require 'config.php';

// Handle the POST request to fetch and update the session details by session_id
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming you have validated and sanitized the input
    $sessionId = isset($_POST["edit_popup_id"]) ? $_POST["edit_popup_id"] : "";

    // Fetch session details for the given session_id
    $selectQuery = "SELECT id, branch_name, date_time, treatment, time_from, time_to, doctor, session_no, status, duration
                    FROM sessions
                    WHERE id = ?";

    $stmt = $conn->prepare($selectQuery);
    $stmt->bind_param("s", $sessionId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Output the session details as JSON
        $response = ["success" => true, "sessionDetails" => $row];
    } else {
        // No sessions found for the given session_id
        $response = ["success" => false, "error" => "No sessions found for the given session_id"];
    }

    // Update session details
    $updateQuery = "UPDATE sessions
                    SET branch_name = ?,
                        date_time = ?,
                        treatment = ?,
                        time_from = ?,
                        time_to = ?,
                        doctor = ?,
                        session_no = ?,
                        duration = ?
                    WHERE id = ?";

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssssss", $branchName, $dateTime, $treatment, $timeFrom, $timeTo, $doctorName, $sessionNo, $duration, $sessionId);

    $branchName = isset($_POST["branch_name"]) ? $_POST["branch_name"] : "";
    $dateTime = isset($_POST["date_time"]) ? $_POST["date_time"] : "";
    $treatment = isset($_POST["treatment"]) ? $_POST["treatment"] : "";
    $timeFrom = isset($_POST["time_from"]) ? $_POST["time_from"] : "";
    $timeTo = isset($_POST["time_to"]) ? $_POST["time_to"] : "";
    $doctorName = isset($_POST["doctor_name"]) ? $_POST["doctor_name"] : "";
    $sessionNo = isset($_POST["session_no"]) ? $_POST["session_no"] : "";
    $duration = isset($_POST["duration"]) ? $_POST["duration"] : "";

    if ($stmt->execute()) {
        $response["updateSuccess"] = true;
    } else {
        $response["updateSuccess"] = false;
        $response["updateError"] = $stmt->error;
    }

    // Output the combined response as JSON
    header("Content-Type: application/json");
    echo json_encode($response);
}

$stmt->close();
$conn->close();
?>

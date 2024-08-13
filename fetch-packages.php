<?php
include 'config.php';

if(isset($_POST['center_type'])) {
    $center_type = $_POST['center_type'];
    $searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';

    // Prevent SQL injection
    $center_type = $conn->real_escape_string($center_type);
    $searchTerm = $conn->real_escape_string($searchTerm);

    // Your SQL query
    $query = "SELECT * FROM manage_packages WHERE centre_type = '{$center_type}' AND pack_name LIKE '%{$searchTerm}%'";
    $results = $conn->query($query);

    if ($results && $results->num_rows > 0) {
        $packages = [];
        while ($row = $results->fetch_assoc()) {
            $packages[] = ['id' => $row['id'], 'text' => $row['pack_name']];
        }
        echo json_encode(['items' => $packages]);
    } else {
        echo json_encode(['items' => []]); // Empty array for no results
    }
}
?>

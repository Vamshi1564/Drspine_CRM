<?php
  include("config.php");
  ?>


<?php

// Retrieve data from POST
$pack_name =mysqli_real_escape_string($conn, $_POST['pack_name']);
$center_type = mysqli_real_escape_string($conn, $_POST['center_type']);
$cost = mysqli_real_escape_string($conn, $_POST['cost']);
$gst = mysqli_real_escape_string($conn, $_POST['gst']);
$in_ex_gst = mysqli_real_escape_string($conn, $_POST['in_ex_gst']);
$gst_amt = mysqli_real_escape_string($conn, $_POST['gst_amt']);
$net_price = mysqli_real_escape_string($conn, $_POST['net_price']);
$notes = mysqli_real_escape_string($conn, $_POST['notes']);
$id = mysqli_real_escape_string($conn,$_POST['id']);
// Handle multiple selected treatments
// $treatment = implode(", ", $_POST['selected_treatments']); // Combine selected treatments into a comma-separated string


// Using prepared statements to prevent SQL injection
$sql = "UPDATE manage_packages 
        SET pack_name = ?, 
            centre_type = ?, 
            cost = ?, 
            in_ex_gst = ?, 
            GST = ?, 
            gst_amt = ?, 
            net_price = ?, 
            Notes = ? 
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssi", $pack_name, $center_type, $cost, $in_ex_gst, $gst, $gst_amt, $net_price, $notes, $id);

if ($stmt->execute()) {
    echo '<script>alert("New record created successfully"); window.location.href = "manage_packages.php";</script>';
} else {
    echo "Error: " . $stmt->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>

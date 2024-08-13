<?php
include 'config.php';

if(isset($_POST['center_type'])) {
    $center_type = $_POST['center_type'];
    $sql = "SELECT * FROM manage_packages WHERE centre_type = '$center_type'";
    $result = $conn->query($sql);
echo '<option value="">Select a package</option>';
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['pack_name'] . '">' . $row['pack_name'] . '</option>';
      }
    }
}
?>

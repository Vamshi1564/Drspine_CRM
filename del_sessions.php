<?php
include 'config.php';
?>

<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit; // Added exit to prevent further execution
} else {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
include("config.php");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    $id = $_GET["id"];

    $sql = "DELETE FROM sessions WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        ?>
        <script>
            window.location = "view_patient_details.php";
            alert("Deleted the selected record");
            window.history.back();
        </script>
        <?php
    } else {
        ?>
        <script>
            window.location = "view_patient_details.php";
            
            alert("Failed to delete record, try again!!!");
            window.history.back();
        </script>
        <?php
    }
}


$conn->close();
?>

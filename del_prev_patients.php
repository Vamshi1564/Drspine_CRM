<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
} else {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
include("config.php");

if ($conn->connect_error) {
    die("connection failed:" . $conn->connect_error);
} else {
    $id = $_GET["id"];

    // Delete the selected row
    $sqlDelete = "DELETE FROM prev_patients WHERE id = $id";

    if ($conn->query($sqlDelete) === TRUE) {
        // Deletion was successful, now update the id values to be continuous
        $sqlUpdate = "SET @count = 0;";
        $sqlUpdate .= "UPDATE prev_patients SET id = @count:= @count + 1;";
        if ($conn->multi_query($sqlUpdate) === TRUE) {
            ?>
            <script>
                window.location = "view-prev-patients.php";
                alert("Deleted the selected record and updated id values.");
            </script>
            <?php
        } else {
            ?>
            <script>
                window.location = "view-prev-patients.php";
                alert("Failed to update id values after deletion.");
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            window.location = "view-prev-patients.php";
            alert("Failed to delete record. Please try again.");
        </script>
        <?php
    }
}
?>

<?php
//  error_reporting(E_ALL);
//  ini_set('display_errors', 1);
// // session_start();
// echo '<script>alert("heloo from update session")</script>';
// if (isset($_POST['branch'])) {
//     if (isset($_SESSION['branch_name_s'])) {
//         unset($_SESSION['branch_name_s']);
//     }
//     $_SESSION['branch_name_s'] = $_POST['branch'];
//     echo '<script>alert('.$_POST["branch"].')</script>';
//     echo '<script>console.log(' . $_SESSION['branch_name_s'] . ')</script>';
//     echo "Session updated successfully";
// } else {
//     echo "Error updating session";
// }


error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if (isset($_POST['branch'])) {
    if (isset($_SESSION['branch_name_s'])) {
        unset($_SESSION['branch_name_s']);
    }
    $_SESSION['branch_name_s'] = $_POST['branch'];

    // Sanitize and validate user input before echoing into JavaScript
    $sanitizedBranch = htmlspecialchars($_POST['branch'], ENT_QUOTES, 'UTF-8');

    echo "Session updated successfully for branch: " . $sanitizedBranch;
} else {
    echo "Error updating session";
}


?>
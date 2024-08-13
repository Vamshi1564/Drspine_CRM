<?php

// Include config file
include_once("config.php");
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// If "login" button clicked
if (isset($_POST['login'])) {
    // Store email
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // Store password
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    // Check email is unique or not
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    if (empty($email)) {
        echo '<script>
                console.log("User Name is Required");
                alert("User Name is Required");
                window.location.href = "login.php?error=User Name is Required";
              </script>';
    } else if (empty($password)) {
        echo '<script>
                console.log("Password is Required");
                alert("Password is Required");
                window.location.href = "login.php?error=Password is Required";
              </script>';
    } else {
        $emailQuery = "SELECT * FROM `manager_login` WHERE email = '$email'";
        $runEmailQuery = mysqli_query($conn, $emailQuery);

        if (!$runEmailQuery) {
            echo '<script>
                    console.log("Query Failed");
                    alert("Query Failed");
                  </script>';
        } else {
            if (mysqli_num_rows($runEmailQuery) > 0) {
                $passwordQuery = "SELECT * FROM `manager_login` WHERE email = '$email' AND password = '$password' AND role='$role'";
                $runPasswordQuery = mysqli_query($conn, $passwordQuery);

                if (!$runPasswordQuery) {
                    echo '<script>
                            console.log("Query Failed");
                            alert("Query Failed");
                          </script>';
                } else {
                    if (mysqli_num_rows($runPasswordQuery) > 0) {
                        $fetchData = mysqli_fetch_assoc($runPasswordQuery);
                        $_SESSION['id'] = $fetchData['id'];
                        $_SESSION['email'] = $fetchData['email'];
                        $_SESSION['mname'] = $fetchData['name'];
                        $_SESSION['branch_name'] = $fetchData['branch'];
                        $_SESSION['role'] = $fetchData['role'];

                        if ($_SESSION['role'] === "admin") {
?>
                            <script>
                                console.log("Redirecting to app_calender.php with branch_name=whitefield");
                                window.location.href = "app_calender.php?branch_name=whitefield";
                            </script>
                        <?php
                        } else {
                        ?>
                            <script>
                                console.log("Redirecting to app_calender.php with branch_name=<?php echo $_SESSION['branch_name']; ?>");
                                window.location.href = "app_calender.php?branch_name=<?php echo $_SESSION['branch_name']; ?>";
                            </script>
                        <?php
                        }
                    } else {
                        echo '<script>
                                console.log("Invalid Password");
                                alert("Invalid Password");
                                window.location.href = "login.php";
                              </script>';
                    }
                }
            } else {
                echo '<script>
                        console.log("Invalid email address");
                        alert("Invalid email address");
                        window.location.href = "login.php";
                      </script>';
            }
        }
    }
}
?>

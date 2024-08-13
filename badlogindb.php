<?php
// include config file
include_once("config.php");
session_start();

// if "login" button clicked
if(isset($_POST['bdlogin'])){
    // store email
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // store password
//$password = md5($_POST['password']);
    $password=mysqli_real_escape_string($conn,md5($_POST['password']));
    // check email is unique or not
    $emailQuery = "SELECT * FROM `user_login` WHERE email = '$email'";
    $runEmailQuery = mysqli_query($conn, $emailQuery);

    if(!$runEmailQuery){
        echo "Query Failed";
    }else{
        if(mysqli_num_rows($runEmailQuery) > 0){
            $passwordQuery = "SELECT * FROM `user_login` WHERE email = '$email' AND password = '$password'";
            $runPasswordQuery = mysqli_query($conn, $passwordQuery);

            if(!$runPasswordQuery){
                echo "Query Failed";
            }else{
                if(mysqli_num_rows($runPasswordQuery) > 0){
                    $fetchData = mysqli_fetch_assoc($runPasswordQuery);
                    $_SESSION['branch_admin_id'] = $fetchData['id'];
                    $_SESSION['branch_admin_email']=$fetchData['email'];
                    $_SESSION['brach_admin_name'] = $fetchData['name'];
                    $_SESSION['branch_name'] = $fetchData['branch'];
                    ?>
                    <script>window.location.href="index.php"</script>
                    <?

                }else{
                    echo '<div class="error-handle error-1" id="mydiv" onclick="this.style.display = \'none\'">Invalid Password <span onclick="this.parentElement.style.display=\'none\'" class="topright">&times</span></div>';?>
                    <script>
                        alert("Invalid Pasword");
                        window.location.href="badlogin.php"</script>
                <?php }
            }
        }else{
            echo "Invalid email address";
            ?>
             <script>window.location.href="badlogin.php"</script>
             <?php
        }
    }
}
?>
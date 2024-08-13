
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- css linked -->
    <link rel="icon" type="image/x-icon" href="dist/img/fav.ico">
    <link rel="shortcut icon" href="dist/img/fav.ico" />
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
   
    
    <div id="container">
        <h2>Login</h2>
        <form  method="POST" action="badlogindb.php" autocomplete="off" id="loginForm">
            <div id="errors">Invalid Email Address</div>
            <input type="email" name="email" id="email" placeholder="Email" required><br>
            <input type="password" name="password" id="password" placeholder="Password" required><br>
            <input type="submit" name="bdlogin" id="login" value="Login">
            <!--<p>Don't have a account? <a href="signup.php">Sign Up</a></p>-->
        </form>
    </div>
     <div class="circle"></div>
    <div class="circle circle2"></div>
    <!-- jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--<script src="js/login.js"></script>-->
</body>
</html>
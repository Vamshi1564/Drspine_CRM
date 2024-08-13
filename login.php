<?php
//include_once("php/config.php");
//session_start();
//if(isset($_SESSION['id'])){
//  header("location: users.php");
//}
?>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-form {
        width: 450px;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .login-form h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .login-form .alert {
        margin-bottom: 15px;
    }

    .login-form label {
        font-weight: bold;
    }

    .login-form select {
        margin-bottom: 15px;
    }

    .login-form button {
        width: 100%;
    }
</style>

<body>

    <div class="container">
        <form class="login-form border shadow p-3 rounded" action="logindb.php" method="post">
            <h1 class="text-center p-3"> CRM Login</h1>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_GET['error'] ?>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
             <div class="mb-1">
                <label class="form-label">Select User Type:</label>
            </div> 
            <select class="form-select mb-3" name="role" aria-label="Default select example">
                <option selected value="fd">Frontdesk</option>
                <option value="admin">Admin</option>
                <option value="cc">Call Center</option>

            </select> 

            <button type="submit" name="login" class="btn btn-primary">LOGIN</button>
        </form>
    </div>


    <!-- jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--<script src="js/login.js"></script>-->
</body>

</html><?php
//include_once("php/config.php");
//session_start();
//if(isset($_SESSION['id'])){
//  header("location: users.php");
//}
?>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .login-form {
        width: 450px;
        padding: 20px;
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .login-form h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    .login-form .alert {
        margin-bottom: 15px;
    }

    .login-form label {
        font-weight: bold;
    }

    .login-form select {
        margin-bottom: 15px;
    }

    .login-form button {
        width: 100%;
    }
</style>

<body>

    <div class="container">
        <form class="login-form border shadow p-3 rounded" action="logindb.php" method="post">
            <h1 class="text-center p-3"> CRM Login</h1>
            <?php if (isset($_GET['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?= $_GET['error'] ?>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
             <div class="mb-1">
                <label class="form-label">Select User Type:</label>
            </div> 
            <select class="form-select mb-3" name="role" aria-label="Default select example">
                <option selected value="fd">Frontdesk</option>
                <option value="admin">Admin</option>
                <option value="cc">Call Center</option>

            </select> 

            <button type="submit" name="login" class="btn btn-primary">LOGIN</button>
        </form>
    </div>


    <!-- jquery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--<script src="js/login.js"></script>-->
</body>

</html>
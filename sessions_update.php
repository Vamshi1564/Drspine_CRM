<!DOCTYPE html>
<?php
include 'config.php';
?>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
} else {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
include("config.php");
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="icon" type="image/x-icon" href="dist/img/fav.ico">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="dist/img/logo.png" alt="JyotiWoodsLogo" height="60" width="80">
        </div>

        <?php include("menu.php"); ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Edit Patient</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Edit Patient</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-md-10">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Sessions</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <?php
                                
if (isset($_POST['submit'])) {
    $id = $_POST['id'];
   
    $patient_id = $_POST['patient_id'];
  //  echo '<script>alert("'.$patient_id.'-----'.$id.'");</script>';
// Retrieve data from POST
                                    $date_time = $_POST['date_time'];
                                    $time_from = $_POST['time_from'];
                                    $time_to = $_POST['time_to'];
                                    $treatment = $_POST['treatment'];
                                    $doctor = $_POST['doctor'];
                                    $session_no = $_POST['session_no']; // Corrected spelling
                                    $status = $_POST['status'];
                                    
                                    // Prepare an SQL statement with placeholders for updating appointments
                                    $update_sql = "UPDATE sessions SET date_time = ?, time_from = ?, time_to = ?, treatment = ?, doctor = ?, session_no = ?, status = ? WHERE id = ?";
                                    $update_stmt = $conn->prepare($update_sql);

                                    if ($update_stmt) {
                                        // Bind parameters to the update statement
                                        $update_stmt->bind_param("sssssssi", $date_time, $time_from, $time_to,  $treatment, $doctor, $session_no, $status, $id);

                                       
                                        // Execute the update statement
                                        $update_result = $update_stmt->execute();
                                        $update_stmt->close();
                                        

                                        // Redirect to a success page or display a success message
                                        if ($update_result) {
                                            echo '<script>alert("Patient information updated successfully.");</script>';
                                            echo '<script>window.location.href = "view_single_patient_details.php?patient_id='.$patient_id. '";</script>';
                                            exit(); // Terminate script execution
                                        }
                                    }
                                }
                                

                                // Check if patient ID is provided via GET
                                if (isset($_GET['id'])) {
                                    $id = $_GET['id'];

                                    // Fetch patient details from the database
                                    $select_sql = "SELECT * FROM sessions WHERE id=?";
                                    $select_stmt = $conn->prepare($select_sql);
                                    $select_stmt->bind_param("i", $id);
                                    $select_stmt->execute();
                                    $result = $select_stmt->get_result();

                                    if ($result->num_rows > 0) {
                                        $row = $result->fetch_assoc();

                                        
                                    }
                                    
                                }
                               
                            
                                
                               
                                ?>


                                <form role="form" method="POST" action="">
                                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row['id']; ?>" >
                   
                    <input type="hidden" class="form-control" id="patient_id" name="patient_id" value="<?php echo $row['patient_id']; ?>" >
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="date">Date</label>
                                            <input type="date" class="form-control" id="date_time" name="date_time" value="<?php echo date('Y-m-d', strtotime($row['date_time'])); ?>" required>
                                        </div>
                                        <div class="row">
                    <div class="form-group col-md-6">
                        <label for="time_from">From</label>
                        <input type="time" class="form-control" id="time_from" name="time_from" value="<?php echo $row['time_from']; ?>" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="time_to">To</label>
                        <input type="time" class="form-control" id="time_to" name="time_to" value="<?php echo $row['time_to']; ?>" required>
                    </div>
                </div>
                                        <div class="form-group">
                                            <label for="treatment">Treatment</label>
                                            <input type="text" class="form-control" id="treatment" name="treatment" value="<?php echo $row['treatment']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="doctor">Doctor</label>
                                            <input type="text" class="form-control" id="doctor" name="doctor" value="<?php echo $row['doctor']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="session_no">Session No</label>
                                            <input type="text" class="form-control" id="session_no" name="session_no" value="<?php echo $row['session_no']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <option value="Scheduled" <?php if ($row['status'] == 'Scheduled') echo 'selected'; ?>>Scheduled</option>
                                                <option value="Attended" <?php if ($row['status'] == 'Scheduled') echo 'selected'; ?>>Attended</option>
                                                <option value="Postponed" <?php if ($row['status'] == 'Scheduled') echo 'selected'; ?>>Postponed</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
       
        <?php include("footer.php"); ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
</body>


</html>
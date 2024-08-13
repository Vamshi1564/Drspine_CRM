<!DOCTYPE html>
<?php
session_start(); 
if(!isset($_SESSION['email'])){
   header("Location:login.php");
}
else
{
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
  <!-- JQVMap -->
 <!--  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css"> -->
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

 <?php include("menu.php");?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Appointment</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Add Lead </li> -->
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
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Appointment</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
        $sql="select * from appointments";
        $result=$conn->query($sql);
        if($result->num_rows>0)
        {
             if($row = mysqli_fetch_assoc($result)) 
             {
        ?>
              <form action="appointmentdb.php" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                  <div class="form-group col-md-4">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="patient_id">Patient Id</label>
                    <input type="text" class="form-control" id="patient_id" name="patient_id" value="" required>
                  </div>
                  <div class="form-group col-md-4">
                          <label for="date">Date</label>
                          <input type="date" class="form-control" id="date" name="date" value="" required>
                      </div>
                  </div>
                  <div class="row">
                  <div class="form-group col-md-4">
                    <label for="time">Time</label>
                    <input type="time" class="form-control" id="time" name="time" value="" required>
                  </div>
                
                  <div class="form-group col-md-4">
                    <label for="age">Age</label>
                    <input type="number" class="form-control" id="age" name="age" value="" placeholder="" required>
                  </div>
                  <div class="form-group col-md-4">
                          <label for="occupation">Occupation</label>
                          <input type="text" class="form-control" id="occupation" name="occupation" value="" required>
                      </div>
                 </div>
                 
                        <div class="row">
                      <div class="form-group col-md-4">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="no_of_session">No of session</label>
                    <input type="number" class="form-control" id="no_of_session" name="no_of_session" required>
                        </div>
                  <div class="form-group col-md-4">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="" required>
                  </div>
                  </div>
                  <div class="row">
                      <div class="form-group col-md-4">
                    <label for="doctor">Doctor</label>
                    <input type="text" class="form-control" id="doctor" name="doctor" value="" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" value="" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="issue">Issue</label>
                    <input type="text" class="form-control" id="issue" name="issue" value="" required>
                  </div>
                  </div>
                  <div class="row">
                      <div class="form-group col-md-4">
                    <label for="payment_status">Payment Status</label>
                    <input type="text" class="form-control" id="payment_status" name="payment_status" value="" required>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="gender">Gender</label>
                    <input type="text" class="form-control" id="gender" name="gender" value="" required>
                  </div>
                  </div>
                     
                  <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </div>
                
               

              </form>
               <?php
              }
            }
                ?> 
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
 <?php include("footer.php");?>
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
<!-- <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
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
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>

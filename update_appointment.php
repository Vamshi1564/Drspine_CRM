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
            <h1 class="m-0">Edit Patient</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Edit Patient </li>
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
              <!-- <div class="card-header">
                <h3 class="card-title">Edit Patient</h3>
              </div> -->
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
                <h3 class="card-title">Edit Patient</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php
              // Check if patient ID is provided via GET
              if (isset($_GET['id'])) {
                  $patient_id = $_GET['id'];

                  // Fetch patient details from the database
                  $select_sql = "SELECT * FROM appointments WHERE id=?";
                  $select_stmt = $conn->prepare($select_sql);
                  $select_stmt->bind_param("i", $patient_id);
                  $select_stmt->execute();
                  $result = $select_stmt->get_result();

                  if ($result->num_rows === 1) {
                      $patient = $result->fetch_assoc();
                  } else {
                      // Handle the case where patient is not found
                      // For example: echo "Patient not found.";
                  }

                  $select_stmt->close();
              }

              if (isset($_POST['submit'])) {
               
                  // Process form submission and update appointment details
                  $appointment_id = $_POST['appointment_id'];
                  $name = $_POST['name'];
                  $patient_id = $_POST['patient_id'];
                  $date = $_POST['date'];
                  $time_from = $_POST['time_from'];
                  $time_to = $_POST['time_to'];
                  $age = $_POST['age'];
                  $occupation = $_POST['occupation'];
                  $email = $_POST['email'];
                 // $no_of_session = $_POST['no_of_session'];
                  $mobile = $_POST['mobile'];
                  $doctor = $_POST['doctor'];
                  $address = $_POST['address'];
                  $issue = $_POST['issue'];
                  $payment_status = $_POST['payment_status'];
                  $gender = $_POST['gender'];
//                   echo '<script>';
// echo 'alert("Appointment ID: ' . $appointment_id . '");';
// echo 'alert("Patient Name: ' . $name . '");';
// echo 'alert("Patient ID: ' . $patient_id . '");';
// echo 'alert("Date: ' . $date . '");';
// echo 'alert("Time from: ' . $time_from . '");';
// echo 'alert("Time to: ' . $time_to . '");';
// echo 'alert("Age: ' . $age . '");';
// echo 'alert("Occupation: ' . $occupation . '");';
// echo 'alert("Email: ' . $email . '");';
// // Add alerts for other variables here
// echo '</script>';

                  // Update the patient's information in the database
                  $update_sql = "UPDATE appointments SET name=?, patient_id=?, date=?, time_from=?, age=?, occupation=?, email=?, time_to=?, mobile=?, doctor=?, address=?, issue=?, payment_status=?, gender=? WHERE id=?";
                  $update_stmt = $conn->prepare($update_sql);
                  $update_stmt->bind_param("ssssssssisssssi", $name, $patient_id, $date, $time_from, $age, $occupation, $email, $time_to, $mobile, $doctor, $address, $issue, $payment_status, $gender, $appointment_id);
                  $update_result = $update_stmt->execute();
                  $update_stmt->close();

                  // Redirect to a success page or display a success message
                  if ($update_result) {
                      echo '<script>alert("Patient information updated successfully.");</script>';
                      echo '<script>';
                      echo 'settime_fromout(function(){ window.location.href = "appointment_list.php"; }, 1000);'; // Redirect after 2 seconds
                      echo '</script>';
                  }
              }
              ?>
              <form action="" method="POST">
                  <input type="hidden" name="appointment_id" value="<?php echo $patient_id; ?>">
                  <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" name="name" value="<?php echo $patient['name']; ?>" required>
                  </div>
                  <div class="form-group">
                      <label for="patient_id">Patient Id</label>
                      <input type="text" class="form-control" id="patient_id" name="patient_id" value="<?php echo $patient['patient_id']; ?>" required>
                  </div>
                  <div class="form-group">
                      <label for="date">Date</label>
                      <input type="text" class="form-control" id="date" name="date" value="<?php echo $patient['date']; ?>" required>
                  </div>
                  <div class="form-group">
                      <label for="time_from">time_from</label>
                      <input type="time" class="form-control" id="time_from" name="time_from" value="<?php echo $patient['time_from']; ?>" required>
                  </div>
                  <div class="form-group">
                      <label for="time_to">time_from</label>
                      <input type="time" class="form-control" id="time_to" name="time_to" value="<?php echo $patient['time_to']; ?>" required>
                  </div>
                  <div class="form-group">
                      <label for="age">Age</label>
                      <input type="number" class="form-control" id="age" name="age" value="<?php echo $patient['age']; ?>" required>
                  </div>
                  <div class="form-group">
                      <label for="occupation">Occupation</label>
                      <input type="occupation" class="form-control" id="occupation" name="occupation" value="<?php echo $patient['occupation']; ?>" required>
                  </div>
                 
                  <div class="form-group">
                      <label for="email">Email</label>
                      <input type="text" class="form-control" id="email" name="email" value="<?php echo $patient['email']; ?>" required>
                  </div>
                  <!-- <div class="form-group">
                      <label for="no_of_session">No of Session</label>
                      <input type="text" class="form-control" id="no_of_session" name="no_of_session" value="<?php echo $patient['no_of_session']; ?>" required>
                  </div> -->
                  <div class="form-group">
                      <label for="mobile">Mobile</label>
                      <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $patient['mobile']; ?>" required>
                  </div>
                  <div class="form-group">
                      <label for="doctor">Doctor</label>
                      <input type="text" class="form-control" id="doctor" name="doctor" value="<?php echo $patient['doctor']; ?>" required>
                  </div>
                  <div class="form-group">
                      <label for="address">address</label>
                      <input type="text" class="form-control" id="address" name="address" value="<?php echo $patient['address']; ?>" required>
                  </div>
                  <div class="form-group">
                      <label for="issue">Issue</label>
                      <input type="text" class="form-control" id="issue" name="issue" value="<?php echo $patient['issue']; ?>" required>
                  </div>
                  <div class="form-group">
                      <label for="payment_status">Payment Status</label>
                      <input type="text" class="form-control" id="payment_status" name="payment_status" value="<?php echo $patient['payment_status']; ?>" required>
                  </div>
                  <div class="form-group">
                      <label for="gender">Gender</label>
                      <input type="text" class="form-control" id="gender" name="gender" value="<?php echo $patient['gender']; ?>" required>
                  </div>
                  <div class="card-footer">
                      <button type="submit" class="btn btn-primary" name="submit">Update</button>
                  </div>
              </form>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
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
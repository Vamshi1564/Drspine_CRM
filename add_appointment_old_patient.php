
<!DOCTYPE html>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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
// Initialize the $patient variable
$patient = [
    'patient_id' => '',
    'name' => '',
    'date_of_birth' => '',
    'age' => '',
    'email' => '',
    'mobile' => '',
    'gender' => '',
    'occupation' => '',
    'address' => '',
];


// If the user has clicked the `search` button, fetch the patient data from the database.
if (isset($_POST['search'])) {
    $patientId = $_POST['patient_id'];
    $sql = "SELECT * FROM appointments WHERE patient_id = '$patientId'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch the patient data and store it in the $patient array
        $patient = $result->fetch_assoc();
        
        // Now, let's calculate the next appointment number
        $sql = "SELECT MAX(appointment_number) AS max_appointment_number FROM appointments WHERE patient_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $patientId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $max_appointment_number = $row["max_appointment_number"];
            // Extract the numeric part
            preg_match('/\d+/', $max_appointment_number, $matches);
            $numeric_part = (int)$matches[0];
            // Increment and format the next appointment number
            $next_appointment_number = "appointment_no_" . ($numeric_part + 1);
        } else {
            // No existing appointments for this patient, start with "appointment_no_1"
            $next_appointment_number = "appointment_no_1";
        }
    } else {
        // Handle the case where no patient was found with the given ID
        echo '<script>alert("Patient ID is :'. $patientId .' not found");</script>';
    }
}
?>

<form action="" method="POST" enctype="multipart/form-data">
    <div class="card-body">
        <div class="row">
            <div class="form-group col-md-4">
                <label for="patient_id">Patient Id</label>
                <input type="text" class="form-control" id="patient_id" name="patient_id" value="<?php echo isset($patient) ? $patient['patient_id'] : ''; ?>" >
            </div>
            
            <div class="form-group col-md-4">
                <button type="submit" name="search" class="btn btn-primary">Search</button>
            </div>
            <br>
            <div class="form-group col-md-4">
                <label for="appointment_number">Appointment Number</label>
                <input type="text" name="appointment_number" value="<?php echo isset($next_appointment_number) ? $next_appointment_number : ''; ?>" >
            </div>
        </div>
    </div>
</form>

              
              <form action="appointmentdb.php" method="POST" enctype="multipart/form-data">
                  <div class="card-body">
                 
                      <input type="hidden" class="form-control" id="patient_id" name="patient_id" value="<?php echo isset($patient) ? $patient['patient_id'] : ''; ?>" hidden>
                      <input type="hidden" class="form-control" name="appointment_number" value="<?php echo isset($next_appointment_number) ? $next_appointment_number : ''; ?>" >
                      <div class="row">
                          <div class="form-group col-md-4">
                              <label for="name">Name</label>
                              <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($patient) ? $patient['name'] : ''; ?>" >
                          </div>
              
                          <div class="form-group col-md-4">
                              <label for="date_of_birth">Date of birth</label>
                              <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?php echo isset($patient) ? $patient['date_of_birth'] : ''; ?>" >
                          </div>
              
                          <div class="form-group col-md-4">
                              <label for="age">Age</label>
                              <input type="number" class="form-control" id="age" name="age" value="<?php echo isset($patient) ? $patient['age'] : ''; ?>" placeholder="" >
                          </div>
                      </div>
              
                      <div class="row">
                          <div class="form-group col-md-4">
                              <label for="email">Email</label>
                              <input type="text" class="form-control" id="email" name="email" value="<?php echo isset($patient) ? $patient['email'] : ''; ?>" >
                          </div>
              
                          <div class="form-group col-md-4">
                              <label for="mobile">Mobile</label>
                              <input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo isset($patient) ? $patient['mobile'] : ''; ?>" >
                          </div>
              
                          <div class="form-group col-md-4">
                    <label for="gender">Gender</label>
                    <!-- <input type="text" class="form-control" id="gender" name="gender" value="" required> -->
                    <select class="form-control" id="gender" name="gender" required>
                      <option value="Male">Male</option>
                      <option value="Female">Female</option>
                    </select>
                  </div>
                      </div>
              
                      <div class="row">
                          <div class="form-group col-md-4">
                              <label for="occupation">Occupation</label>
                              <input type="text" class="form-control" id="occupation" name="occupation" value="<?php echo isset($patient) ? $patient['occupation'] : ''; ?>" >
                          </div>
              
                          <div class="form-group col-md-4">
                              <label for="address">Address</label>
                              <input type="text" class="form-control" id="address" name="address" value="<?php echo isset($patient) ? $patient['address'] : ''; ?>" >
                              </div>
              </div>
              <div class="row">
                      <div class="form-group col-md-4">
                    <label for="doctor">Doctor</label>
                    <!-- <input type="text" class="form-control" id="doctor" name="doctor" value="" > -->
                    <select name="doctor" class="form-control doctor-select" style="width:100% !important;">
        <option value="Select Doctor">Select Doctor</option>
        <option value="Dr.john">Dr. John</option>
            <option value="Dr.Viraj">Dr. Viraj</option>
            <option value="Dr.Mahathi">Dr. Mahathi</option>
            <option value="Dr.Soujanay">Dr. Soujanay</option>
        </select>
                  </div>
                 
                  <div class="form-group col-md-4">
                    <label for="issue">Issue</label>
                    <input type="text" class="form-control" id="issue" name="issue" value="" >
                  </div>
                  <div class="form-group col-md-4">
                    <label for="purpose"></label>
                    <input type="text" class="form-control" id="purpose" name="purpose" value="Appointment" hidden>
                    <!-- <select class="form-control" id="purpose" name="purpose" required>
                      <option value="appointment">Appointment</option>
                      <option value="session">Session</option>
                    </select> -->
                   
                  </div>
                  </div>
                 
                        <div class="row">
                        <div class="form-group col-md-4">
                          <label for="date">Date</label>
                          <input type="date" class="form-control" id="date" name="date" value="" >
                      </div>
                  <div class="form-group col-md-4">
                    <label for="time_from">Time From</label>
                    <input type="time" class="form-control" id="time_from" name="time_from" value="" >
                  </div>
                  <div class="form-group col-md-4">
                    <label for="time_to">Time To</label>
                    <input type="time" class="form-control" id="time_to" name="time_to" value="" >
                  </div>
                  <!-- <div class="form-group col-md-4">
  <label for="branch_name">Branch Name</label>
  <select class="form-control" id="branch_name" name="branch_name" required>
  <option value="Select Branch Name">Select Branch Name</option>
    <option value="WF">WF</option>
    <option value="BEL">BEL</option>
    <option value="IND">IND</option>
  </select>
</div> -->
                  </div>
                  
                  <div class="row">
                  <div class="form-group col-md-4">
  <label for="payment_status">Payment Status</label>
  <select class="form-control" id="payment_status" name="payment_status" >
    <option value="paid">Paid</option>
    <option value="not_paid">Not Paid</option>
  </select>
</div>

                  
                  </div>
                 
              <div class="card-footer">
                  <button type="submit" name="submit" class="btn btn-primary">Add</button>
                </div>
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

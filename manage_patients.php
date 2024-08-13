<!DOCTYPE html>
<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

session_start(); 
if(!isset($_SESSION['email'])){
   header("Location:login.php");
} else {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
include("config.php");
?>
<html lang="en">
<head>
  <?php
  include("config.php");
  ?>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link rel="icon" type="image/x-icon" href="dist/img/fav.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo.png" alt="JyothiWoodsLogo" height="60" width="80">
  </div>
  
  <?php include("menu.php");?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="width:'fit-content';">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View Appointments</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">View Appointments</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

             <div class="card">
              <div class="card-header">
                <a href="add-appointment.php" class="btn btn-primary text-right">Add Appointment +</a>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped" style="box-shadow: 1px 2px 4px 0px #8080804f;">
                  <thead>
                  <tr>
                    <th hidden>NO</th>
                    <th>Patient ID</th>
                    <th>Appointment Number</th>
                    
                    <th>Appointment Date & Time</th>
                    <th>Duration (minutes)</th>
                    <th>Doctor Name</th>
                    <th>Patient First Name</th>
                    <th>Patient Middle Name</th>
                    <th>Patient Last Name</th>
                    <th>Contact Number</th>
                    <th>Email Address</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Age</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
    $sql = "SELECT * FROM `drspine_appointment` WHERE branch_name='whitefield'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {
       while($row = mysqli_fetch_assoc($result)) {
    ?>
                <tr>
                    <td hidden><?php echo $row["id"]?></td>
                    <td><?php echo $row["patient_id"]?></td>
                    <td><?php echo $row["appointment_number"]?></td>
                    
                    <td><?php echo $row["appointment_date_time"]?></td>
                    <td><?php echo $row["duration_minutes"]?></td>
                    <td><?php echo $row["doctor_name"]?></td>
                    <td><?php echo $row["patient_first_name"]?></td>
                    <td><?php echo $row["patient_middle_name"]?></td>
                    <td><?php echo $row["patient_last_name"]?></td>
                    <td><?php echo $row["contact_no"]?></td>
                    <td><?php echo $row["email_address"]?></td>
                    <td><?php echo $row["gender"]?></td>
                    <td><?php echo $row["date_of_birth"]?></td>
                    <td><?php echo $row["age"]?></td>
                    <td>
                      <a class="btn btn-info btn-sm" href="edit_appointment.php?id=<?php echo $row["id"] ?>" name="edit">
                    <i class="fa fa-pencil-square-o white edit"></i>  
                  </a>
                      <a class="btn btn-danger btn-sm" href="del_appointment.php?id=<?php echo $row["id"] ?>">
                    <i class="fa fa-trash white trash"></i> 
                  </a></td>
                  </tr>
                 <?php
               }
             } else {
              ?>
               <tr>
        <td colspan="16"><?php echo "No Records found";?></td>
        </tr>
              <?php
             }
                 ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
 <?php include("footer.php");?>
  <aside class="control-sidebar control-sidebar-dark"></aside>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>
</body>
</html>

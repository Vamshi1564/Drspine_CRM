
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
            <h1>View New Patients</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">New Patients</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

             <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Patients</h3>
              </div>
             
  

 



<div class="card-body">
<!-- Download Form -->
<div class="row col-12" style="margin-top:10px; margin-left: 15px;">
    <form class="form-inline" method="POST" action="download_patient_data_csv.php">
        <label>Start Date:</label>&nbsp;&nbsp;
        <input type="date" class="form-control" name="start_date" required>&nbsp;&nbsp;&nbsp;&nbsp;
        <label>End Date:</label>&nbsp;&nbsp;
        <input type="date" class="form-control" name="end_date" required>&nbsp;&nbsp;
        <button type="submit" class="btn btn-success" name="download"><i class="fa fa-download"></i> Download</button>
    </form>
</div>

<p>OR</p>
<!-- Month-wise Download Form -->
<!-- Month-wise Download Form -->
<div class="row col-12" style="margin-top:10px; margin-left: 15px;">
    <form class="form-inline" method="POST" action="download_month.php">
        <label>Select Month and Year:</label>&nbsp;&nbsp;

        <!-- Month Dropdown -->
        <select class="form-control" id="month" name="month">
    <?php
    $current_year = date("Y");
    $current_month = date("m");

    // Calculate the end month for the current year
    $end_month = ($current_year == $_POST['year']) ? $current_month : 1;

    for ($month = 12; $month >= $end_month; $month--) {
        $selected = ($current_month == $month && $current_year == $_POST['year']) ? 'selected' : '';
        echo "<option value=\"$month\" $selected>" . date('F', mktime(0, 0, 0, $month, 1)) . "</option>";
    }
    ?>
</select>
        &nbsp;&nbsp;
        <!-- Year Dropdown -->
<select class="form-control" id="year" name="year" required>
    <?php
    $current_year = date("Y");
    for ($i = $current_year; $i >= 2017; $i--) {
        echo "<option value=\"$i\">$i</option>";
    }
    ?>
</select>
        &nbsp;&nbsp;
        <button type="submit" class="btn btn-success" name="download_month"><i class="fa fa-download"></i> Download</button>
    </form>
</div>



</div>





        
      </div>
      
    </section>
    

  </div>
  
 

  
<?php #include("upload_excel.php"); ?>
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
<!-- AdminLTE for demo purposes -->
<!-- <script src="../../dist/js/demo.js"></script> -->
<!-- Page specific script -->







</body>
</html>

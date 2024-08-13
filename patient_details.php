  


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
  <style>
        #searchResults {
              top: 70px;
    left: 15px;
            position: absolute;
            width: 100%;
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #ccc;
            background-color: #fff;
            z-index: 1000;
        }

        .result {
            padding: 8px;
            cursor: pointer;
        }

        .result:hover {
            background-color: #f0f0f0;
        }
    </style>

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
        <div class="row">
          <div class="col-sm-6">
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Information</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

 



  <style>
    .card-body {
  background-color: #f7f7f7;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
  
  width:100%;
}

.card-body table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 15px;
}

.card-body td {
  padding: 5px;
  border: 1px solid #ddd;
}

.card-body p.heading {
  font-weight: bold;
  margin: 0;
}
.card-body p.data {
  margin-top: 18px;
}

.card-body a {
  text-decoration: none;
  color: #007bff;
}

.card-body a:hover {
  text-decoration: underline;
}

.card-body a:active {
  color: #0056b3;
}

.card-body a:focus {
  outline: none;
}
  </style>

<!-- 
<form method="GET">

  <label for="patient_id">Enter Patient ID:</label>
  <input type="text" name="patient_id" id="patient_id">
  <input type="submit" value="Search/View Details">
</form> -->

    <div class="card-body col-md-12">
     
<form method="POST" action="">
   <div class="col-md-10 row">
  <div class="col-md-4">
  <!-- <label for="search">Enter Patient ID, Email, or Mobile:</label> -->
  <label for="search">Enter Patient ID :</label>
  <input type="text" name="search" id="search" class="form-control" autocomplete="off">
  </div>
  <!--<div class="col-md-4">
  <label for="branch_name">Select Branch</label><br/>
    <select name="branch_name" id="branch_name" class="form-control">
    <option value="whitefield">Whitefield</option>
    <option value="BEL Road">BEL Road</option>
    <option value="Indira Nagar">Indira Nagar</option>
  </select></div>-->
     <div id="searchResults" class="col-md-4"></div>
     
  <!--<input type="submit" name="search_btn" class="btn btn-primary" value="Search/View Details" style="height: 40px; margin-top:30px;">-->

   </div>
</form>
     
    </div>
<!-- /.content-wrapper -->


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php include("footer.php");?>
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

  
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
$(document).ready(function(){
   $('#search').on('input', function(){
      var search = $(this).val();
      if(search.length >= 3){
         $.ajax({
            url: 'search_ajax.php',
            method: 'POST',
            data: {search: search},
            success: function(response){
              console.log(response);
               $('#searchResults').html(response);
            }
         });
      } else {
         $('#searchResults').empty();
      }
   });
   
   $(document).on('click', '.result', function(){
     
    //  var selectedValue = $(this).text();
     //console.log(selectedValue);
      //$('#search').val(selectedValue);
      //$('#searchResults').empty();
        var selectedPatientId = $(this).data('patient-id');
    var selectedBranchName = $(this).data('branch-name');

    // Redirect to another page with parameters
    window.location.href = 'view_single_patient_details.php?patient_id=' + selectedPatientId + '&branch_name=' + selectedBranchName;

   });
});
</script>

</body>
</html>

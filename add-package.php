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
            <h1 class="m-0">Add Package</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <!--<ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Add Package </li>
            </ol>-->
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
                <h3 class="card-title">Add Package</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
             
              <form action="packagedb.php" method="POST" enctype="multipart/form-data">
                <div class="card-body">
                <!-- <h3>Basic info</h3><br> -->
                <div class="row">
                <div class="form-group col-md-4">
                    <label for="pack_name">Package Name</label>
                    <input type="text" class="form-control" id="pack_name" name="pack_name" autocomplete="off" value="" required>
                  </div>
                  <!-- <div class="form-group col-md-4">
                    <label for="pname">Name</label>
                    <input type="text" class="form-control" id="pname" name="pname" value="" required>
                  </div> -->
                  <div class="form-group col-md-4">
                    <label for="center_type">Center Type</label>
                    <select name="center_type" class="form-control" id="center_type" required>
                    <option  value="healthcare" Selected>MJVA healthcare Pvt Ltd</option>
                    <option  value="wellness">MJVA Wellness Pvt Ltd</option>
                    <option  value="AIS LLP" >Asian Institute of Scoliosis LLP</option>
                  </select>
                  </div>
       	
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                     <label for="cost">Basic Cost</label>
                   <input type="number" min="0" step="any" class="form-control" id="cost" name="cost" value="" required>
                    </div>
                  <div class="form-group col-md-4" id="in_ex_gst_fld">
                     <label for="in_ex_gst">Incl/Excl GST</label>
                      <select class="form-control" name="in_ex_gst" id="in_ex_gst">
                        <option value="Exclusive of GST">Exclusive of GST</option>
                        <option value="Inclusive of GST">Inclusive of GST</option>
                      </select>
                    </div>
                    
                  <div class="form-group col-md-4">
                    <label for="gst">GST</label>
                    <input type="number" min="0" step="any" class="form-control" id="gst" name="gst" value="" required>
                  </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-md-4">
                    <label for="gst_amt">GST Amount</label>
                    <input type="number" min="0" step="any" class="form-control" id="gst_amt" name="gst_amt" value="" required>
                  </div>
                    
                  <div class="form-group col-md-4">
                    <label for="net_price">Net Price</label>
                    <input type="number" min="0" step="any" class="form-control" id="net_price" name="net_price" value="" required>
                  </div>
                  </div>
                  <div class="row">
                     <div class="form-group col-md-4">
                    <label for="notes">Notes</label>
                    <textarea class="form-control" id="notes" name="notes"></textarea>
                    </div>
                  </div>
                
                  
                </div>
                <div class="card-footer" style="background-color:white;">
                  <button type="submit" class="btn btn-primary" style="width: 100px;">Add</button>
                </div>


              </form>
             
            </div>
            

          </div>
          
        </div>
        
        
      </div>
    </section>
   
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


<script type="text/javascript">
    //$(document).ready(function() {
      //  $("#center_type").on("change", function() {
        //    var type = $('#center_type').find("option:selected").val();
          //  if (type == "healthcare") {
            //    $("#gst").val(0);
              //$("#in_ex_gst_fld").hide();
               //$("#gst_amt").val(0);
                //$("#gst").prop("readonly", true);
                //$("#gst_amt").prop("readonly", true);
            //} else if (type == "wellness") {
              //  $("#gst").val(18);
              //$("#in_ex_gst_fld").show();
                //$("#gst").prop("readonly", false);
              //$("#gst_amt").prop("readonly", false);
            //}
        //});

        // Trigger change event on page load to apply the logic
        //$("#center_type").trigger("change");
    //});

    $(document).ready(function() {
        $("#center_type").on("change", function() {
            var type = $('#center_type').find("option:selected").val();
            if (type == "healthcare") {
                $("#gst").val(0);
                $("#in_ex_gst_fld").hide();
                $("#gst_amt").val(0);
                $("#gst").prop("readonly", true);
                $("#gst_amt").prop("readonly", true);
              } else if (type == "wellness" || type == "AIS LLP") {
                $("#in_ex_gst_fld").show();
                $("#gst").prop("readonly", false);
                $("#gst_amt").prop("readonly", false);
            }

            calculateAmountAndGST();
        });

        // Trigger change event on page load to apply the logic
        $("#center_type").trigger("change");

        // Trigger calculation on input change
        $("#in_ex_gst, #cost, #gst").on("input", function() {
            calculateAmountAndGST();
        });

        function calculateAmountAndGST() {
            var cost = parseFloat($("#cost").val()) || 0;
            var gstRate = parseFloat($("#gst").val()) || 0;
            var inExGst = $("#in_ex_gst").val();

            if (inExGst === "Exclusive of GST") {
                var gstAmount = (cost * gstRate) / 100;
                var totalAmount = cost + gstAmount;
            } else {
                var gstAmount = (cost * gstRate) / (100 + gstRate);
                var totalAmount = cost - gstAmount;
            }

            $("#gst_amt").val(gstAmount.toFixed(2));
            $("#net_price").val(totalAmount.toFixed(2));
        }
    });
</script>
 
</body>
</html>

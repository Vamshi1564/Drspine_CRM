<!DOCTYPE html>
<?php
session_start(); 
if(!isset($_SESSION['mname'])){
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
  <title>Manager Dashboard</title>
 <link rel="icon" type="image/x-icon" href="dist/img/fav.ico">
 <link rel="shortcut icon" href="dist/img/fav.ico" />
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
    <img class="animation__shake" src="dist/img/logo.png" alt="JyothiWoodsLogo" height="60" width="80">
  </div>

  <!-- /.navbar -->

 <?php include("menu.php");?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
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
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
           <div class="small-box bg-success">
              <div class="inner">
                <?php
    
    $sql="select count(*) as c from leads";
    $result=$conn->query($sql);

    if($result->num_rows>0)
    {
       if($row = mysqli_fetch_assoc($result)) 
       {
    ?>
                <h3><?php echo $row["c"];?><sup style="font-size: 20px"></h3>
<?php
}
}
?>
                <p>View All Leads</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-person-add"></i> -->
                <i class="fa fa-user-o"></i>
              </div>
              <a href="view-leads.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>


          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-color: #507eff;color: white;">
              <div class="inner">
                <h3>&nbsp  </h3>
                 <p>Add Leads</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-pie-graph"></i> -->
                <i class="ion ion-person-add" aria-hidden="true"></i>
              </div>
              <a href="add-leads.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>





          <!-- ./col -->
         <div class="col-lg-3 col-6">
         <div class="small-box bg-success">
              <div class="inner">
                  <?php
    
    $sql="select count(*) as c from patients ";
    $result=$conn->query($sql);

    if($result->num_rows>0)
    {
       if($row = mysqli_fetch_assoc($result)) 
       {
    ?>
                <h3><?php echo $row["c"];?><sup style="font-size: 20px"></h3>
<?php
}
}
?>
          <p>View All Patients</p>
              </div>
              <div class="icon">
                <i class="fa fa-user-o"></i>
              </div>
              <a href="view-patients.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> 

          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box" style="background-color: #507eff;color: white;">
              <div class="inner">
                <h3>&nbsp  </h3>
                 <p>Add Patients</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-pie-graph"></i> -->
                <i class="ion ion-person-add" aria-hidden="true"></i>
              </div>
              <a href="add-patients.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>

          <!-- ./col -->
      <div class="col-lg-3 col-6">     
        <div class="small-box bg-danger">
          <div class="inner">
    <?php
    $sql="select count(*) as c from prev_patients ";
    $result=$conn->query($sql);

    if($result->num_rows>0)
    {
       if($row = mysqli_fetch_assoc($result)) 
       {
    ?>
                <h3><?php echo $row["c"];?><sup style="font-size: 20px"></h3>
<?php
}
}
?>

               <p>View Previous Patients</p>
              </div>
              <div class="icon">
                <!-- <i class="ion ion-pie-graph"></i> -->
                <i class="fa fa-user-o"></i>
              </div>
              <a href="view-prev-patients.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          

          
        
  
          
        

           

            <!-- <div class="col-lg-3 col-6"> -->
            <!-- small box -->
            <!-- <div class="small-box" style="background-color: #ffb150;color: white;">
              <div class="inner">
                <h3>&nbsp  </h3>
                 <p>View Sales Managers</p>
              </div>
              <div class="icon"> -->
                <!-- <i class="ion ion-pie-graph"></i> -->
               <!--  <i class="fa fa-address-book-o " aria-hidden="true"></i>
              </div>
              <a href="view-sales-manager.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->

          <!-- <div class="col-lg-3 col-6"> -->
            <!-- small box -->
            <!-- <div class="small-box" style="background-color: #07b88f;color: white;">
              <div class="inner">
                <h3>&nbsp  </h3>
                 <p>View Review Chart</p>
              </div>
              <div class="icon"> -->
                <!-- <i class="ion ion-pie-graph"></i> -->
               <!--  <i class="fa fa-bar-chart " aria-hidden="true"></i>
              </div>
              <a href="review-chart.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div> -->
          
           <!-- <div class="col-lg-3 col-6"> -->
            <!-- small box -->
           <!--  <div class="small-box" style="background-color: #8122c8;color: white;">
              <div class="inner">
                <h3>&nbsp  </h3>
                 <p>View Livechat Leads</p>
              </div>
              <div class="icon"> -->
                <!-- <i class="ion ion-pie-graph"></i> -->
               <!--  <i class="fa fa-comments-o" aria-hidden="true"></i>
              </div>
              <a href="view_livechat_leads.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
 -->
        </div>
        <!-- /.row -->
        <!-- Main rowRequire a call from sales person -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-7 connectedSortable">

        
          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-lg-5 connectedSortable">

  
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
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

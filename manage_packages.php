
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
            <h1>View Packages</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="app_calender.php">Home</a></li>
              <li class="breadcrumb-item active">View Packages</li>
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
                <!-- <h3 class="card-title">View Branch Admin</h3> -->
                <a href="add-package.php" class="btn btn-primary text-right">Add Package +</a>
              </div>
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped" style="box-shadow: 1px 2px 4px 0px #8080804f;">
                  <thead>
                  <tr>
                    <th hidden>NO</th>
                    <th width="42%">Name</th>
                    <th width="8%">Ceter Type</th>
                    <th>Cost</th>
                    <th width="5%">GST</th>         
                    <th>Notes</th>
                    <!-- <th>Lead Type</th> -->
                    <th width="10%">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
    
    $sql="select * from manage_packages";
    $result=$conn->query($sql);

    if($result->num_rows>0)
    {
       while($row = mysqli_fetch_assoc($result)) 
       {
    ?>
                <tr>
                    <td hidden><?php echo $row["id"]?></td>
                    <td width="42%"><?php echo $row["pack_name"]?></td>
                    <td width="8%"><?php echo $row["centre_type"]?></td>
                    <td><?php echo $row["cost"]?></td>
                    <td width="5%"><?php echo $row["GST"]?></td>
                    <td><?php echo $row["Notes"]?></td>
                    <td width="8%">
                      <a class="btn btn-info btn-sm" href="edit_package.php?id=<?php echo $row["id"] ?>" name="edit">
                    <i class="fa fa-pencil-square-o white edit"></i>  
                  </a>
                      <a class="btn btn-danger btn-sm" href="del_package.php?id=<?php echo $row["id"] ?>">
                    <i class="fa fa-trash white trash"></i> 
                  </a></td>
                  </tr>

                 <?php
               }
             }
             else{
              ?>
               <tr>
        <td colspan="6"><?php echo "No Records found";?></td>
        </tr>
              <?php
             }
                 ?>
                  </tbody>
                  <!-- <tfoot>
                  <tr>
                    <th hidden>NO</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Budget Range</th>
                    <th>Enquiry</th>
                    <th>Campaign</th>
                    <th>keyword</th>
                    <th>Camp Medium</th>
                    <th>Camp Source</th>
                    <th>Content</th>
                    <th>Match Type</th>
                    <th>gclid</th>
                    <th>Device</th>
                    <th>Browser</th>
                    <th>User IP</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Date & Time</th>
                    <th>Comment</th>
                  </tr>
                  </tfoot> -->
                </table>
              </div>
            </div>
          </div>
          <!-- /.col -->
          
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>

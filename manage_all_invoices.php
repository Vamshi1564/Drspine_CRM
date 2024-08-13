
<!DOCTYPE html>
<?php
session_start(); 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

  <style type="text/css">
    .table-container {
    max-width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
}

th {
    background-color: #f2f2f2;
}

/* Optional: Add some styling for better readability */
/* You can customize these styles further */
th, td {
    border: 1px solid #ddd;
}

/* Add hover effect to rows */
tr:hover {
    background-color: #f5f5f5;
}
div.dt-buttons {
    position: initial;
    float: right !important;
    margin-left: 22px !important;
}
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo.png" alt="" height="60" width="80">
  </div>
  
  <?php include("menu.php");?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="width:'fit-content';">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View All Invoices</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
             
              <li class="breadcrumb-item active">Invoice</li>
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
                <h2 class="card-title">Invoices</h2>
                <div style="float:right">
                <?php
if($_SESSION['role'] === 'admin' && $_SESSION['role'] != 'fd' && $_SESSION['role'] != 'cc')

{
   ?>
  <select class="form-control" name="branch_name" id="filterDropdown">
    <option value="All" selected="">All</option>
  <option value="whitefield" >WhiteField</option>
  <option value="BEL Road">BEL Road</option>
  <option value="Indira Nagar">Indira Nagar</option>
</select>
<?php
}
else
{
  ?>
                  
  <!--<span style="font-size:18px"><?php echo $_SESSION['branch_name']?></span>-->
                  <select class="form-control" name="branch_name" id="filterDropdown">
    <?php
    $options = array("All", "whitefield", "BEL Road", "Indira Nagar");
    foreach ($options as $option) {
        $selected = ($_SESSION['branch_name'] == $option) ? 'selected' : '';
        $disabled = ($_SESSION['branch_name'] == $option) ? '' : 'disabled';
        echo "<option value=\"$option\" $selected $disabled>$option</option>";
    }
    ?>
</select>

  <?php
}
?>
  </div>
              </div>
            

 

  <!-- Bulk Upload Starts -->
  <style>
    #excelForm {
      margin-left: 23px;
      margin-top: 30px;
      
      
    }
  </style>
  <br>

<div class="card-body">
<div class="p-2" style="box-shadow: 0px 0px 4px 1px lightgray">
    <form class="form-inline" action="" method="post">
        <label class="mr-2" for="from_date">From:</label>
        <input type="date" class="form-control mr-2" id="from_date" name="from_date" required>

        <label class="mr-2" for="to_date">To:</label>
        <input type="date" class="form-control mr-2" id="to_date" name="to_date" required>

        <input type="text" id="b_name" name="b_name" value="<?php echo $_SESSION['branch_name'] ?>" hidden/>

        <button type="submit" name="filter" class="btn btn-info">Submit</button>
    </form>
</div>

  <hr/>
<div class="table-container" id="tableContainer">
    
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
<script>
   
    //$(function() {
     // $("#example1").DataTable({
       // "responsive": false,
        //"lengthChange": false,
        //"autoWidth": false,

   //   }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
     // $('#example2').DataTable({
      //  "paging": true,
       // "lengthChange": false,
        //"searching": false,
       // "ordering": true,
       // "info": true,
        //"autoWidth": false,
        //"responsive": true,
      //});
   // });
  </script>

<script>
// $(document).ready(function(){
//     $("#filterDropdown").change(function(){
//         var selectedBranch = $(this).val();
//         $.ajax({
//             type: "GET",
//             url: "get_invoice_data.php",
//             data: { branch: selectedBranch },
//             success: function(data){
//                 $("#tableContainer").html(data);
//             }
//         });
//     });
// });


 // $(document).ready(function(){
    // Function to fetch and update table data
   // function updateTable(branch) {
     //   $.ajax({
       //     type: "GET",
         //   url: "get_invoice_data.php",
           // data: { branch: branch },
           // success: function(data){
             //   $("#tableContainer").html(data);
            //}
        //});
   // }

    // Trigger the initial data load with "All" selected
    //updateTable('All');

    // Handle dropdown change event
    //$("#filterDropdown").change(function(){
      //  var selectedBranch = $(this).val();
        //updateTable(selectedBranch);
    //});
//});
  
$(document).ready(function(){
    var table;
    function updateTable(branch, fromDate, toDate) {
        $.ajax({
            type: "GET",
            url: "get_invoice_data.php",
            data: { 
                branch: branch,
                from_date: fromDate,
                to_date: toDate
            },
            success: function(data){
                if ($.fn.DataTable.isDataTable("#example1")) {
                    $('#example1').DataTable().clear().destroy();
                }

                $("#tableContainer").html(data);

                table = $("#example1").DataTable({
                    "responsive": false,
                    "lengthChange": false,
                    "autoWidth": false,
                    "order": [[1, "desc"]],
                    "dom": 'Bfrtip',
                    "buttons": ['csv', 'excel', 'pdf', 'print']
                });
            }
        });
    }

    $("#filterDropdown").change(function(){
        var selectedBranch = $(this).val();
        var fromDate = $("#from_date").val();
        var toDate = $("#to_date").val();
        updateTable(selectedBranch, fromDate, toDate);
    });

    $("form").on('submit', function(e){
        e.preventDefault();
        var branch = $("#filterDropdown").val();
        var fromDate = $("#from_date").val();
        var toDate = $("#to_date").val();
        updateTable(branch, fromDate, toDate);
    });

    var initialBranch = $("#filterDropdown").val();
    var initialFromDate = $("#from_date").val();
    var initialToDate = $("#to_date").val();
    updateTable(initialBranch, initialFromDate, initialToDate);
});

  
  

</script>




</body>
</html>

<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location:login.php");
} else {
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
      <img class="animation__shake" src="dist/img/logo.png" alt="" height="60" width="80">
    </div>

    <?php include("menu.php"); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="width:'fit-content';">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>View All Receipts</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Receipts</li>
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
                  <h3 class="card-title">Receipts</h3>
                  <a href="view_single_patient_details.php?patient_id=<?php echo $_GET['patient_id']; ?>&branch_name=<?php echo $branch_name; ?>" style="float:right">Return to Pateints Page</a>
                </div>
                <div class="row col-12" style="margin-top:10px; margin-left: 15px;">

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
                  <?php
                  if (isset($_GET['patient_id'])) {
                    $patient_id = $_GET['patient_id'];
                    $branch_name = $_GET['branch_name'];
                    // $invoice_id = $_GET['invoice_id'];

                    // Fetch data from the database (using the provided SQL query)
                    //         $sql = "SELECT r.id as r_id,r.recpt_id as recpt_id,r.invoice_id,r.pdf_file_path, r.total_amount,r.paid_amount, p.payment_type, r.created_at, p.*
                    // FROM receipts r
                    // LEFT JOIN payments p ON r.recpt_id = p.receipt_id
                    // WHERE r.patient_id = '$patient_id' and r.invoice_id = p.invoice_id ORDER BY r.created_at DESC";

                    $sql = "SELECT r.id as r_id,r.recpt_id as recpt_id,r.invoice_id,r.pdf_file_path, r.total_amount,r.paid_amount, p.payment_type, r.created_at, p.* FROM receipts r LEFT JOIN invoices i ON i.invoice_code = r.invoice_id LEFT JOIN payments p ON r.recpt_id = p.receipt_id WHERE i.branch_name ='$branch_name' and r.patient_id = '$patient_id' and r.invoice_id = p.invoice_id ORDER BY r.created_at DESC";
                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                      // $invoiceCode = $row['invoice_code'];
                      // $paymentst = $row['payment_status'];
                      // $pat_id= $row['patients_id'];

                      // Add the item data to the corresponding invoice code
                      $recpt_id = $row['recpt_id'];
                      $total_amount = $row['total_amount'];
                      $payment_type = $row['payment_type'];
                      $amount = $row['paid_amount'];
                      $path = $row['pdf_file_path'];
                      // echo $path;
                      // Loop through grouped invoices and display them
                      // foreach ($groupedInvoices as $invoiceCode => $invoiceData) {
                  ?>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="row ml-0 mr-0" style="background: lightgray; border-top-left-radius: 2px; border-top-right-radius: 2px;">
                            <div class="col-md-4">
                              <h4 class="p-1 m-0">Receipt ID: <?php echo $recpt_id; ?></h4>

                            </div>
                            <div class="col-md-4">
                              <h5 class="p-1 m-0" style="float:right">Date: <?php echo $row['created_at']; ?></h5>
                            </div>
                            <div class="col-md-4 text-right">
                              <i class="fa fa-print ml-4 p-1 btn btn-primary" style="float:right;" onclick="openPrintWindow('<?php echo $path; ?>')"></i>

                              <script type="text/javascript">
                                function openPrintWindow(pdfFilePath) {
                                  window.open(pdfFilePath, "_blank");
                                }
                              </script>
 <?php
                              if($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'fd' && $_SESSION['role'] != 'cc')
                              {
                                ?>
                                 <a href="delete_receipt.php?id=<?php echo $row['r_id']?>&recpt_id=<?php echo $recpt_id; ?>&branch_name=<?php echo $branch_name?>&patient_id=<?php echo $patient_id?>" style="float:right;">
                                   <i class="fa fa-trash ml-4 p-1" style="color:red"></i></a>

                              <?php
                              }
                             ?>
	
                            </div>
                          </div>
                          <table id="example1" class="mt-0 table table-bordered jsgrid-table" style="box-shadow: 1px 2px 4px 0px #8080804f; margin-top: 0px !important; margin-bottom: 15px !important;">
                            <tr>
                              <th>Invoice No</th>
                              <th>Amount</th>
                              <th>Mode of Payment</th>
                            </tr>
                            <tr>
                              <td><?php echo $row['invoice_id']; ?></td>
                              <td><?php echo $amount; ?></td>
                              <td>
                                <?php
                                if ($payment_type === "Cash")
                                  echo $payment_type;
                                elseif ($payment_type === "Card")
                                  echo $payment_type . ",&nbsp&nbsp Card Number :  ****-****-****-" . substr($row['cardNumber'], -4);
                                elseif ($payment_type === "Online")
                                  echo  $payment_type . ",&nbsp&nbsp" . $row['paid_using'] . '<br/>' . "Transaction Id : " . $row['transaction_id'];
                                elseif ($payment_type === "Cheque")
                                  echo  $payment_type . '<br/>' . "Cheque No." . substr($row['cheque_number'], -4);
                                ?></td>
                            </tr>
                          </table>
                        </div>
                      </div>

                    <?php
                    }
                    // }

                  } else {
                    ?>
                    <div>
                      <table>
                        <tr>
                          <td>No records found</td>
                        </tr>
                      </table>
                    </div>
                  <?php
                  }

                  ?>

                </div>



              </div>

      </section>


    </div>


    <?php #include("upload_excel.php"); 
    ?>
    <!-- /.content-wrapper -->
    <?php include("footer.php"); ?>

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
    $(function() {
      $("#example1").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,

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


  <!-- Popup Modal Starts -->

  <div id="patientModal" class="modal fade">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Patient Details</h4>

        </div>
        <div class="modal-body text-center" id="patientDetails">
          <!-- Patient details will be displayed here -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Popup Modal Starts -->






</body>

</html>
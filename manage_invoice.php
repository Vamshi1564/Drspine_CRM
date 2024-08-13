<!DOCTYPE html>
<?php
session_start();
error_reporting(E_ALL);
ini_set('display-errors',1);
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
              <h1>View All Invoices</h1>
            </div>
            <div class="col-sm-6">
              <!--<ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>-->
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
                  <h3 class="card-title">Invoice</h3>
                  <a href="view_single_patient_details.php?patient_id=<?php echo $_GET['patient_id']; ?>&branch_name=<?php echo $branch_name; ?>" style="float:right">Return to Pateints Page</a>

                </div>
                <div class="row col-12" style="margin-top:10px; margin-left: 15px;">
                  <a href="invoice.php?patient_id=<?php echo $_GET['patient_id']; ?>&branch_name=<?php echo $_GET['branch_name'] ?>" class="btn btn-sm btn-primary">+ Create Invoice</a>
                
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
                  <!-- <form action="" method="post">
  <label for="from_date">From:</label>
  <input type="date" id="from_date" name="from_date" required>

  <label for="to_date">To:</label>
  <input type="date" id="to_date" name="to_date" required>
<input type="text" id="b_name" name="b_name" value="<?php echo $_SESSION['branch_name']?>" hidden/>
   <button type="submit" name="filter" class="btn btn-info">Submit</button>
</form>-->

                  <?php
                  if (isset($_GET['patient_id'])) {
                    $patient_id = $_GET['patient_id'];
                    $branch_name = $_GET['branch_name'];
                    // $mobile = $_GET['mobile'];

                    // Fetch data from the database (using the provided SQL query)
                    $sql = "SELECT 
            i.id AS invoice_id,
            i.invoice_code,
            i.patients_id,
            i.consultant_name,
            i.centre_type,
            i.sub_total,
            i.total,
            i.pending_amt,
            i.note,
            i.branch_name,
            i.invoice,
            i.payment_status,
            i.created_on AS invoice_created_on,
            i.created_by AS invoice_created_by,
            ii.id AS item_id,
            ii.qty,
            ii.price AS item_price,
            ii.gst AS item_gst,
            ii.discount AS item_discount,
            ii.total AS item_total,
            p.id AS package_id,
            p.pack_name,
            p.centre_type,
            p.cost AS package_cost,
            p.GST AS package_gst,
            p.Notes AS package_notes,
            p.created_on AS package_created_on
        FROM invoices i
        LEFT JOIN invoice_items ii ON i.id = ii.invoice_id
        LEFT JOIN manage_packages p ON ii.package = p.pack_name where i.patients_id ='$patient_id' and i.branch_name ='$branch_name' ORDER BY i.created_on DESC";

                    $result = $conn->query($sql);

                    // Create an empty array to store grouped invoice data
                    $groupedInvoices = [];

                    // Group the data by invoice code
                    while ($row = $result->fetch_assoc()) {
                      $invoiceCode = $row['invoice_code'];
                      $paymentst = $row['payment_status'];

                      $pat_id = $row['patients_id'];
                      // Create a new entry for the invoice code if it doesn't exist
                      if (!isset($groupedInvoices[$invoiceCode])) {
                        $groupedInvoices[$invoiceCode] = [
                          'invoice_data' => $row, // Invoice data
                          'items' => [], // Array to store invoice items
                        ];
                      }
                      // Add the item data to the corresponding invoice code
                      $groupedInvoices[$invoiceCode]['items'][] = $row;
                    }

                    // Loop through grouped invoices and display them
                    foreach ($groupedInvoices as $invoiceCode => $invoiceData) {
                  ?>
                      <div class="row">

                        <div class="col-md-12 mb-4 pl-0 pr-0" style="border:1px solid gray;">
                          <div class="row ml-0 mr-0" style="background: lightgray; border-top-left-radius: 2px;border-top-right-radius: 2px;">
                            <div class="col-md-6">
                              <h4 class="p-1 m-0"><?php echo $invoiceCode; ?></h4>
                            </div>
                            <div class="col-md-6 text-right">
                              <!-- <a style="float:right;" data-pdf-path="<?php echo $invoiceData['invoice_data']['invoice']; ?>"><i class="fa fa-print ml-4 p-1"></i></a> -->
                              <a href="<?php echo $invoiceData['invoice_data']['invoice']; ?>" target="_blank" style="float:right;"><i class="fa fa-print ml-4 p-1" onclick="openPrintWindow('<?php echo $invoiceData['invoice_data']['invoice']; ?>')"></i></a>

                              
  <script type="text/javascript">
    function openPrintWindow(pdfPath) {
      window.open(pdfPath, "_blank");
    }
  </script>
                             <?php
                              if($_SESSION['role'] === 'admin' && $_SESSION['role'] != 'fd' && $_SESSION['role'] != 'cc')
                              {
                                ?>
                                 <a href="edit_invoice.php?id=<?php echo $invoiceData['invoice_data']['invoice_id']; ?>&invoice_id=<?php echo $invoiceData['invoice_data']['invoice_code'];?>" target="_blank" style="float:right;">
                                   <i class="fa fa-edit ml-4 p-1"></i></a>

                              <?php
                              }
                             ?>
	
                              	  <?php
                              if($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'fd' && $_SESSION['role'] != 'cc')
                              {
                                ?>
                                 <a href="delete_invoice.php?id=<?php echo $invoiceData['invoice_data']['invoice_id']; ?>&invoice_id=<?php echo $invoiceData['invoice_data']['invoice_code'];?>&branch_name=<?php echo $branch_name?>" style="float:right;">
                                   <i class="fa fa-trash ml-4 p-1" style="color:red"></i></a>

                              <?php
                              }
                             ?>
	
                              

                              <a style="float:right;"><i class="fa fa-envelope ml-4 p-1"></i></a>
                              <?php if ($invoiceData['invoice_data']['payment_status'] === "Due") {
                              ?>
                                <a style="float:right;color:red;" class="ml-4 p-1" href="add-money.php?patient_id=<?php echo $pat_id; ?>&invoice_code=<?php echo $invoiceCode; ?>">Due</a>
                              <?php
                              } elseif ($invoiceData['invoice_data']['payment_status'] === "Paid") {
                              ?>
                                <a style="float:right;color:Green; cursor: not-allowed;pointer-events: none;" id="myLink" class=" ml-4 p-1" href="<?php echo $invoiceData['invoice_data']['invoice']; ?>">Paid</a>
                                <script type="text/javascript">
                                  document.getElementById("myLink").addEventListener("click", function(event) {

                                    event.preventDefault(); // Prevent the default behavior of the link
                                    // Optional: Show a message indicating the link is disabled

                                  });
                                </script>
                              <?php
                              } ?>
                            </div>
                          </div>
                          <table id="example1" class="mt-0 table table-bordered jsgrid-table" style="box-shadow: 1px 2px 4px 0px #8080804f;margin-top: 0px !important;">
                            <tr>
                              <th width="40%">Item</th>
                              <th>Qty</th>
                              <th>Price</th>
                              <th>GST</th>
                              <th>Discount</th>
                              <th>Total</th>
                            </tr>

                            <?php
                            // echo "<h2>{$invoiceCode}</h2>";
                            // echo "<table id="example1" class="table table-bordered jsgrid-table" style="box-shadow: 1px 2px 4px 0px #8080804f;">";
                            // echo "<tr><th>Item</th><th>Qty</th><th>Price</th><th>GST</th><th>Discount</th><th>Total</th></tr>";

                            // Display invoice items
                            foreach ($invoiceData['items'] as $item) {
                              echo "<tr>";
                              echo "<td>{$item['pack_name']}</td>";
                              echo "<td>{$item['qty']}</td>";
                              echo "<td>{$item['item_price']}</td>";
                              echo "<td>{$item['item_gst']}</td>";
                              echo "<td>{$item['item_discount']}</td>";
                              echo "<td>{$item['item_total']}</td>";
                              echo "</tr>";
                            }

                            // echo "</table>";
                            ?>
                          </table>
                          <div class="row p-2">
                            <div class="col-md-6">
                              <span style="color: green;font-size: 20px;">Category : <?php
                                                                                      if ($invoiceData['invoice_data']['centre_type'] === "wellness")
                                                                                        echo "MJVA Wellness Pvt Ltd";
                                                                                      else
                                                                                        echo "MJVA Healthcare Pvt Ltd";  ?> </span>
                            </div>
                            <div>
                              <span style="color: green;font-size: 20px;">Total : <?php echo $invoiceData['invoice_data']['total'] ?> &nbsp;&nbsp; Received: <?php echo (($invoiceData['invoice_data']['total']) - ($invoiceData['invoice_data']['pending_amt'])) ?> &nbsp;&nbsp; Due : <?php echo $invoiceData['invoice_data']['pending_amt'] ?>&nbsp;&nbsp; Payment Status : <?php echo $invoiceData['invoice_data']['payment_status'] ?></span>
                            </div>
                          </div>
                        </div>
                      </div>
                    <?php
                    }
                    ?>



                  <?php
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

                  <!-- <?php //} 
                        ?> -->

                </div>



              </div>

      <!--</section>-->


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

</body>

</html>
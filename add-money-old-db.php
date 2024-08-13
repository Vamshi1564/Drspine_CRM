
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
 <!-- Bulk Upload Starts -->
  <style>
    #excelForm {
      margin-left: 23px;
      margin-top: 30px;
      
      
    }
  </style>

  <style>
    
    .tabs {
    display: flex;
/*    justify-content: space-around;*/
/*    margin: 20px 0;*/
}

.tab-button {
    padding: 2px 6px;
    cursor: pointer;
/*    background-color: #f1f1f1;*/
margin-left: 5px;
}

.tab-content {
    margin-top: 20px;
}

#cardTab input {
    margin-bottom: 10px;
}
.tab-button.active {
    background-color: #0c4684 !important; /* Set your desired active tab color here */
    border: 1px solid #0c4684 !important;
    color: #fff;
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
        <div class="row mb-2">
          <div class="col-sm-6">
            <!-- <h1>View All Invoices</h1> -->
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <!-- <li class="breadcrumb-item active">Invoice</li> -->
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
                <h3 class="card-title">Add Payment</h3>
              </div>
               <div class="row col-12" style="margin-top:10px; margin-left: 15px;">
             
              </div>

  
<!-- Bulk Upload Ends -->

<div class="card-body">

  <div class="col-md-8">

<?php
if(isset($_GET['patient_id']))
{
  $patient_id = $_GET['patient_id'];
  $invoice_code = $_GET['invoice_code'];

  $sql = "SELECT 
            i.id AS invoice_id,
            i.invoice_code,
            i.patients_id,
            i.consultant_name,
            i.sub_total,
            i.total,
            i.note,
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
        LEFT JOIN manage_packages p ON ii.package = p.pack_name where i.patients_id ='$patient_id' and i.invoice_code = 
        '$invoice_code'";

$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
  ?>
  <div><p><?php echo $row['pack_name'];?></p>
<p><?php echo $row['total'];?></p>
  </div>

     <div class="tabs">
        <button class="tab-button btn btn-primary btn-sm active" type="button"  data-tab="cash" onclick="showTab('cash')">Cash</button>
        <button class="tab-button btn btn-primary btn-sm" type="button"  data-tab="card" onclick="showTab('card')">Card</button>
        <button class="tab-button btn btn-primary btn-sm" type="button"  data-tab="online" onclick="showTab('online')">Online Payment</button>
        <button class="tab-button btn btn-primary btn-sm" type="button"  data-tab="cheque" onclick="showTab('cheque')">Cheque</button>
    </div>
    <div id="cashTab" class="tab-content">
      <form method="POST" action="add-money-db.php">
        <input type="text" name="payment_type" id="payment_type" value="Cash" hidden>
        <input type="text" name="invoice_id" value="<?php echo $invoice_code;?>" hidden>
        <input type="text" name="invoice_pid" value="<?php echo $row['invoice_id'];?>" hidden>

        <input type="text" name="patient_id" value="<?php echo $patient_id;?>" hidden>

        <div class="row col-xs-8">
          <div class="col-xs-2 mr-2"><label for="cash_amount"> Amount</label></div>
          <div class="col-xs-4 mr-2"><input type="number" name="cash_amount" id="cash_amount"/></div>
         <div class="col-xs-2 mr-2">
        <input type="submit" class="btn btn-success btn-sm" name="add_cash_payment" value="ADD"/></div>
       </div>
      </form>
    </div>
    <div id="cardTab" class="tab-content" style="display:none;">
        <form method="POST" action="add-money-db.php">
           <input type="text" name="payment_type" value="Card" hidden>
           <input type="text" name="invoice_id" value="<?php echo $invoice_code;?>" hidden>
            <input type="text" name="invoice_pid" value="<?php echo $row['invoice_id'];?>" hidden>
        <input type="text" name="patient_id" value="<?php echo $patient_id;?>" hidden>

           <div class="row col-md-8">
            <div class="col-md-4"><label>Card Number</label></div>
            <div class=col-md-4>
              <input type="text"  id="cardNumber" name="cardnumber" value="">
            </div></div>
            <div class="row col-md-8">
              <div class="col-md-4">
              <label for="card_amt">Amount</label></div>
              <div class="col-md-4"><input type="text" id="card_amt" name="card_amt" value=""></div>
            </div>
            <div class="col-md-5 text-center">
               <input type="submit" name="add_card_payment" class="btn btn-success btn-sm" id="add_card_payment" value="Add"/>
            </div> 
      </form>
    </div>
    <div id="onlineTab" class="tab-content" style="display:none;">
        <form method="POST" action="add-money-db.php">
          <input type="text" name="payment_type"  value="Online" hidden>
          <input type="text" name="invoice_id" value="<?php echo $invoice_code;?>" hidden>
           <input type="text" name="invoice_pid" value="<?php echo $row['invoice_id'];?>" hidden>
        <input type="text" name="patient_id" value="<?php echo $patient_id;?>" hidden>

          <div class="row col-md-8">
          <div class="col-md-4"><label for="paid_by">Paid BY</label></div>
          <div class="col-md-4">
            <select class="" name="paid_by" id="paid_by">
            <option value="netbanking">Net Banking</option>
            <option value="paytm">Paytm</option>
            <option value="razorpay">Razorpay</option>
            <option value="googlepay">GooglePay</option>
            <option value="mobikwik">Mobikwik</option>
            <option value="Others">Others</option>
          </select>
          </div>           
          </div>
          <div class="row col-md-8">
            <div class="col-md-4"> <label for="transaction_id">Transaction ID</label> </div>
            <div class="col-md-4"><input type="text" name="transaction_id" id="transaction_id"/></div>
         </div>
         <div class="row col-md-8">
            <div class="col-md-4"> <label for="online_amt">Amount</label> </div>
            <div class="col-md-4"><input type="text" name="online_amt" id="online_amt"/></div>
         </div>
         <div class="col-md-5 text-center">
            <input type="submit" name="add_online_payment" id="add_online_payment" value="Add">
         </div>
         
        </form>
    </div>
    <div id="chequeTab" class="tab-content" style="display:none;">
        <form method= "POST" action="add-money-db.php">
           <input type="text" name="payment_type" value="Cheque" hidden>
           <input type="text" name="invoice_id" value="<?php echo $invoice_code;?>" hidden>
            <input type="text" name="invoice_pid" value="<?php echo $row['invoice_id'];?>" hidden>
        <input type="text" name="patient_id" value="<?php echo $patient_id;?>" hidden>

           <div class="row col-md-8">
           <div class="col-md-4"><label for="">Bank Name</label></div>
           <div class="col-md-4"><input type="text" id="bank_name" name="bank_name"></div>
         </div>
         <div class=" row col-md-8">
            <div class="col-md-4"><label> Cheque Number</label></div>
            <div class="col-md-4"><input type="text" id="cheque_number" name="cheque_number"></div>
          </div>
          <div class="row col-md-8">
          <div class="col-md-4"><label>Amount</label></div>
          <div class="col-md-4"><input type="text" id="cheque_number" name="cheque_number"></div>
            
          </div>
        <div class="col-md-5 text-center"></div>
        <input type="submit" name="add_cheque_payment" class="btn btn-success btn-sm" id="add_cheque_payment" value="Add"/>
      </form>
    </div>

  <?php
  }

}
?>
<!-- <input type="submit" class="btn btn-primary btn-sm" name="submit" value="Submit"/>  -->
  </div>

</div>


        
      </div>
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
  $(function () {
    $("#example1").DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
      
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

<script>
//   function showTab(tabName) {
//     var tabs = document.getElementsByClassName("tab-content");
//     for (var i = 0; i < tabs.length; i++) {
//         // tabs[i].style.display = "none";
//        tabs[i].classList.remove("active");
//     }

//     // document.getElementById(tabName + "Tab").style.display = "block";
//      document.getElementById(tabName + "Tab").style.display = "block";
//     document.querySelector(".tabs button[data-tab='" + tabName + "']").classList.add("active");

// }

function showTab(tabName) {
    var tabs = document.getElementsByClassName("tab-content");
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].style.display = "none";
    }

    var buttons = document.getElementsByClassName("tab-button");
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove("active");
    }

    document.getElementById(tabName + "Tab").style.display = "block";
    document.querySelector(".tabs button[data-tab='" + tabName + "']").classList.add("active");
}

</script>

</body>
</html>

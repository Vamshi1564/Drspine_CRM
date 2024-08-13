
<!DOCTYPE html>
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
if(!isset($_SESSION['email'])){
   header("Location:login.php");
}
else
{
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
include("config.php");


if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['invoice_id'])) {
    $invoice_code = $_GET['invoice_id'];
  $invoice_id = $_GET['id'];

    // Fetch invoice data from the database
    $sql = "SELECT * FROM invoices WHERE id = $invoice_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $invoice_data = $result->fetch_assoc();
    } else {
        echo "Invoice not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
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
            <h1>Invoice</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Invoice</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
 <?php
        function getQuotationDetails($conn, $iid) {
    $invoiceId = $conn->real_escape_string($iid); // Sanitize input

    $query = "SELECT q.*, ii.* FROM invoices q JOIN invoice_items ii ON q.id = ii.invoice_id
              WHERE q.id = '$invoiceId'";
    
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $quotationData = $result->fetch_assoc();
        $quotationItems = [];
        foreach ($result as $row) {
            $quotationItems[] = [
               'invoice_item_id' => $row['id'],
                'package' => $row['package'],
                'qty' => $row['qty'],
                'price' => $row['price'],
               'discount' => $row['discount'],
                'gst' => $row['gst'],
              'total' => $row['total']   
            ];
        }

        // Add quotation items array to the main quotation data
        $quotationData['quotation_items'] = $quotationItems;

        return $quotationData;
    } else {
        return false; // Quotation not found
    }
}

$iid = $_GET['id'];
$quotationDetails = getQuotationDetails($conn, $iid);

// Close the database connection
// $conn->close();

        ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

             <div class="card">
              <div class="card-header">
                <!-- <h3 class="card-title">View Branch Admin</h3> -->
                <!-- <a href="add-package.php" class="btn btn-primary text-right">Add Package +</a> -->
              </div>
              <div class="card-body">
                  <form action="edit_invoicedb.php" method="POST" enctype="multipart/form-data">
                    <?php
                    //if(isset($_GET['patient_id']))
                    //{
                      $patient_id = $invoice_data['patients_id'];
                      $branch_name = $invoice_data['branch_name'];
                      // $mn = $_GET['mobile'];
                      // $pemail = $_GET['email'];
                         // Fetch patient details using $patient_id
    $sql = "SELECT * FROM drspine_appointment WHERE patient_id = '$patient_id'"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        // Handle case where no patient found
        echo "Patient not found.";
        exit();
    }
                    //}
                    ?>
                    <input type="text" name="patient_name" id="pateint_name" value="<?php echo $patient['patient_first_name'] ." " . $patient['patient_last_name']?>" hidden>
                    <input type="text" name="patient_id" id="pateint_id" value="<?php echo $patient['patient_id'];?>" hidden>
 <input type="text" name="invoice_id" id="" value="<?php echo $invoice_id?>" hidden>
                    <input type="text" name="invoice_code" id="" value="<?php echo $invoice_code;?>" hidden>

                    <div class="row">
                      
                       <div class="col-md-4">
                        <select class="form-control" name="consultant" id="consultant"> 
                         <?php
                          
                                $sql1 = "select * from doctor where branch_name = '$branch_name'";
                                $result1 = $conn->query($sql1);
                                if ($result1->num_rows > 0) {
                                  while ($row1 = mysqli_fetch_assoc($result1)) {
                                ?>
                              <option value="<?php echo $row1["doctor_name"] ?>" <?php echo ($row1["doctor_name"] === $invoice_data['consultant_name']) ? 'selected' : ''; ?>><?php echo $row1["doctor_name"] ?></option>
                            <?php
                                  }
                                }
                            ?>
                        </select>

          
                      </div>


                      <div class="col-md-4">
                        <select class="form-control" name="center_type" id="center_type"> 
                          <option  value="wellness" <?php echo ($invoice_data['centre_type'] === 'wellness') ? 'selected' : ''; ?>>MJVA Wellness Pvt Ltd</option>
                          <option  value="healthcare" <?php echo ($invoice_data['centre_type'] === 'healthcare') ? 'selected' : ''; ?> >MJVA healthcare Pvt Ltd</option>
                          
                        </select>
                      </div>

                      <div class="col-md-3" style="float: right;">
                        <input type="text" style="float: right;" class="form-control" name="branch_name" id="branch_name" value="<?php echo $branch_name;?>"readonly>
                        
                      </div>
                    </div><br/>
                <!-- <div class="row border border-dark" >   -->
                   <!--  <div class="col-md-8 border-right border-dark" >
                        <h2 style="float:left;" class="pt-2">Soumya</h2></br></br>
                        <h2 style="font-size:20px;color:lightskyblue;" class="pt-5 pb-4">GSTIN:</h2>
                    </div> -->
                    <!-- <div class="col-md-4 pt-1">
                        <div class="py-1 input-group">
                            <input class="form-control" type="text" id="purchaseNo" name="purchaseNo"/>
                            <label class="form-control col-sm-5" for="purchaseNo">Purchase No</label>
                        </div>
                        <div class="py-1 input-group">
                            <input class="form-control" type="date" id="purchaseDate" name="purchaseDate" required/>
                            <label class="form-control col-sm-5" for="purchaseDate">Purchase Date</label>
                        </div>
                        <div class="py-1 input-group">
                            <input class="form-control" type="date" id="dueDate" name="dueDate" required>
                             <label class="form-control col-sm-5" for="dueDate">Due Date</label>
                        </div>
                    </div> -->
                <!-- </div> -->

        
        <div class="row border-dark border-right border-left border-top border-bottom" id="box_loop_1">
            <div class="col-md-3 p-3 border-right border-left border-bottom">
                <input type="number" name="itemno" id="itemno" select-group="" data-count=1 hidden />
                    <!-- <input class="form-control" list="product" name="product_choice" id="product_choice" onchange="checkvalue(this.value)" placeholder="Product" /> -->
                    <label for="product_choice">Package Name</label>
                      <input class="form-control" list="product" name="product_choice" id="product_choice" placeholder="Package" />
    <datalist name="product" id="product"></datalist>

            </div>
              
              <div class="col-md-2 p-3 border-right border-bottom">
                 <label for="qty">Quantity</label>
                 <input class="form-control" type="number" min="1" name="qty" id="qty" value="1">
              </div>
          
              <div class="col-md-2 p-3 border-right border-bottom" id="pricevalbox">
                 <label for="price">Price</label>
                 <?php
                if($_SESSION['role'] === 'fd' && $_SESSION['role'] != 'cc' && $_SESSION['role'] != 'admin')
                {
                  ?>
                <input type="number" class="form-control" name="price" id="price" value="" readonly >
                 <?php
                }else if($_SESSION['role'] === 'admin' && $_SESSION['role'] != 'fd')
                { 
                ?>
                <input type="number" class="form-control" name="price" id="price" value="" >
                 <?php
                }
                ?>
               
              </div>
              <div class="col-md-2 p-3 border-right border-bottom" >
                 <label for="discount">Discount</label>
                 <?php
                if($_SESSION['role'] === 'fd' && $_SESSION['role'] != 'cc' && $_SESSION['role'] != 'admin')
                {
                  ?>
                <input type="number" class="form-control" name="discount" id="discount" value="" min="0" readonly>
                 <?php
                }else if($_SESSION['role'] === 'admin' && $_SESSION['role'] != 'fd')
                {  
                ?>
                <input type="number" class="form-control" name="discount" id="discount" value="" min="0">
                 <?php
                }
                ?>
               
              </div>
               <div class="col-md-2 p-3 border-right border-bottom" >
                 <label for="gst">GST</label>
                  <?php
                if($_SESSION['role'] === 'fd' && $_SESSION['role'] != 'cc' && $_SESSION['role'] != 'admin')
                {
                  ?>
                <input type="number" min="0" class="form-control" name="gst" id="gst" value="" readonly>
                 <?php
                }else if($_SESSION['role'] === 'admin' && $_SESSION['role'] != 'fd')
                {
                  ?>
                   <input type="number" min="0" class="form-control" name="gst" id="gst" value="">
                 <?php
                }
                ?>
              </div>
          <input type="text" name="gst_amt" id="gst_amt" value="" hidden/>
          <input type="text" name="net_price" id="net_price" value="" hidden/>
          <input type="text" name="in_ex_gst" id="in_ex_gst" value="" hidden/>
          
                 <div class="col-md-1 p-3 border-right border-bottom">
                <button type="button" class="btn btn-success btn-sm" name="Addmore" id="addmore" onclick="add_more()">Add</button>
              </div>
            </div>  

             <div class="row border border-dark m-2">
                <table class="table table-bordered" id="item-list">
                  <colgroup>
                    <col width="18%">
                    <col width="13%">
                    <col width="14%">
                    <col width="18%">
                     <col width="18%">
                  </colgroup>
                  <thead>
                    <tr>
                      <th class="text-center">Package </th>
                      <th class="text-center">Quantity</th>
                      <th class="text-center">Price</th>
                       <th class="text-center">Discount</th>
                       <th class="text-center">GST</th>
                      <th class="text-center">Total</th>
                    </tr>
                  </thead>
                   
                  <tbody>
                       <?php
                     $tot_amt =0;
                     $index =0;
          foreach ($quotationDetails['quotation_items'] as $item) {
              
    // Formatting to 2 decimal places
            
$gstamt = ($item['price'] * ($item['gst'] / 100.0));
$gstamt = round($gstamt, 2); // rounding to 2 decimal places

          
            ?>
            <tr>
              <td><?php echo $item['package']; ?></td>
              <td><?php echo $item['qty']; ?></td>
              <td><?php echo $item['price']; ?></td>
              <td><?php echo $item['discount']. '%'; ?></td>
              <td><?php echo $gstamt .'('.$item['gst']. '%)';?></td>
              
              <td><?php echo $item['total']; ?></td>
              <td><button class="btn btn-sm btn-outline-danger" type="button" onclick="rem_item($(this), <?php echo $item['invoice_item_id']; ?>)"><i class="fa fa-trash" style="color:red;"></i></button></td>

              <input type="hidden" name="products[<?php echo $index; ?>][packages]" value="<?php echo $item['package']; ?>">
<!-- <input type="hidden" name="products[<?php echo $index; ?>][invoice_item_id]" value="<?php echo $item['invoice_item_id']; ?>">-->
        <input type="hidden" name="products[<?php echo $index; ?>][priceval]" value="<?php echo $item['price']; ?>">
        <input type="hidden" name="products[<?php echo $index; ?>][qtyvalue]" value="<?php echo $item['qty']; ?>">
        <input type="hidden" name="products[<?php echo $index; ?>][discountval]" value="<?php echo $item['discount']; ?>">
        <input type="hidden" name="products[<?php echo $index; ?>][gstval]" value="<?php echo $item['gst']; ?>">
                 <input type="hidden" name="products[<?php echo $index; ?>][gstamtval]" value="<?php echo $gstamt; ?>">

          <input type="hidden" name="products[<?php echo $index; ?>][total]" value="<?php echo $item['total']; ?>">
          

              
            </tr>
            <?php
            $tot_amt += $item['total']; 
            $index++;
          }
          ?>

                  </tbody>
                  <tfoot>

                    <tr>
                       <th colspan="3" rowspan="2"><textarea class="form-control" name="note" id="note" placeholder="Note"></textarea></th>
                      <th class="text-right" colspan="2">Sub Total</th>
                      <th class="text-right" id="sub_total"><?php echo $tot_amt;?>
                        <input type="hidden" name="sub_total"  value="<?php echo $tot_amt;?>">
                      </th>
                    </tr>
                 
                 <!--    <tr>
                      <th class="text-right" colspan="2">Additional Payable</th>-->
                      <!-- <th class="text-right" id="tax_rate"></th> -->
                     <!-- <th><input type="number" class="form-control" name="pack_price" id="pack_price" value="0" onchange="calc_total();"></th>
                    </tr> -->
                    <tr>
                      <th class="text-right" colspan="2">Grand Total</th>
                      <th class="text-right" name="gtotal" id="gtotal"><?php echo $tot_amt;?></th>
                      <input type="hidden" name="total_amount" value="<?php echo $tot_amt;?>">
                    </tr>
                  </tfoot>
                </table>
        
            </div>
            <div class="row">
                <!-- <div class="col-md-6 border-left border-right border-bottom border-dark p-3">
                    <textarea class="form-control" placeholder="Terms and Condition" name="terms_condition" id="terms_condition" cols="20" style="width: -webkit-fill-available;height: 112px;"><?php echo isset($note) ? $note : ''; ?></textarea>
                </div> -->
               <!--  <div class="col-md-6 border-right border-bottom border-dark p-3">
                  <div >
                    <h6>For Soumya</h6>
                    <h6>Authorized Signatory</h6>
                  </div>
                </div> -->
            </div>

                <div class="row col-md-12 text-center pt-3">
                    <div class="col-md-2"><input type="submit" class="btn btn-primary " name="submit" value="Submit" /></div>
                     <div class="col-md-2"><input type="reset" class="btn btn-danger " name="cancel" value="Cancel" /></div>
                </div>
                       
                        <!-- </div> -->
                      </form>
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

  <script type="text/javascript">
    count =  <?php echo count($quotationDetails['quotation_items']); ?>;

    itemno = 1;

    function add_more() {

      
      package = $('#product_choice').val();
       itemno = $('#itemno').val();
      qty = parseInt($('#qty').val());
      in_ex_gst = $('#in_ex_gst').val();

      if(in_ex_gst == "Exclusive of GST")
      {
        price = parseFloat($('#price').val());
      }
      else if(in_ex_gst == "Inclusive of GST")
      {
        price = parseFloat($('#net_price').val());
      }else{
        price = parseFloat($('#price').val());
      }
      
      gst = parseFloat($('#gst').val());
      discount = parseFloat($('#discount').val());
      if(discount == "")
      {
        discount = 0;
      }
     
       var totalWithoutDiscount = qty * price;
var discountAmount = (totalWithoutDiscount * discount) / 100;
var totalBeforeGST = totalWithoutDiscount - discountAmount;

if(gst === 0)
{
  var gstamt = 0;
}
else
{
  var gstamt = (totalWithoutDiscount * (gst / 100));
  gstamt = parseFloat(gstamt.toFixed(2));
}
var total1= ((totalBeforeGST + gstamt).toFixed(2));
      

      // total = parseFloat(price) * parseFloat(qty);
     // var html = '<tr><td>' + package + '</td><td>' + qty + '</td><td>' + price + '</td><td>' + discountAmount +' (' + discount + ' %)</td><td>' + gstamt +'('+ gst +' %)</td><td>' + total + 
        //'<input type="number" name="itemnum[]" id="itemnumval' + count + '" value="' + itemno + '" hidden/>'+
      //ut  name="packages[]" id="packagesval' + count + '" value="' + package + '" hidden/>'+
        //input type="number" name="qtyvalue[]" id="qtyvalueval' + count + '" value="' + qty + '" hidden/>'+
          //input type="number" name="priceval[]" id="priceval' + count + '" value="' + price + '" hidden/>'+
          //input type="number" name="gstval[]" id="gstval' + count + '" value="' + gst + '" hidden/>'+
          //input type="number" name="discountval[]" id="discountval' + count + '" value="' + discount + '" hidden/>'+
          //input type="number" name="total[]" id="total' + count + '" value="' + total + '" hidden/>'+
          ///td><td><button class="btn btn-sm btn-outline-danger" type="button" onclick="rem_item($(this))"><i class="fa fa-trash" style="color:red;"></i></button></td></tr>';
 
      var html ='<tr>' +
            '<td>' +  package+ '<input type="hidden" name="products[' + count + '][packages]" value="' +  package + '"></td>' +
           '<td>' + qty + '<input type="hidden" name="products[' + count + '][qtyvalue]" value="' + qty + '"></td>' +
            '<td>' + price + '<input type="hidden" name="products[' + count + '][priceval]" value="' + price + '"></td>' +
            '<td>'+discount+'('+'%)'+'<input type="hidden" name="products[' + count + '][discountval]" value="' + discount + '"></td>' +
           '<td>' + gstamt + '('+gst+'%)'+ '<input type="hidden" name="products[' + count + '][gstval]" value="' + gst + '">' + 
          '<input type="hidden" name="products[' + count + '][gstamtval]" value="' + gstamt + '">' +
         
            '<td>' + total1 + '<input type="hidden" name="products[' + count + '][total]" value="' + total1 + '"></td>' +
              
               '<td><button class="btn btn-sm btn-outline-danger" type="button" onclick="rem_item1($(this))"><i class="fa fa-trash" style="color:red;"></i></button></td>' +
            '</tr>';
      $('#item-list tbody').append(html);
      $('#discount').val('').trigger('change');
      $('#product_choice').val('').trigger('change');
      $('#qty').val('').trigger('change');
      $('#price').val('').trigger('change');
      $('#gst').val('').trigger('change');
      count++;
      // console.log(count);
      // alert(count);
      itemno++;
      calc_total();
     
    }

   // function calc_total() {
     // var total = 0;
      //var total1 = 0;
      //var pack_price = $('#pack_price').val();
      //$('#item-list tbody tr').each(function() {
        //var tr = $(this)
        //var lineTotal = tr.find('[name="products[][total]"]').val();
//if (!lineTotal || isNaN(lineTotal)) {
  //  lineTotal = 0;
//} else {
  //  lineTotal = parseFloat(lineTotal);
//}
  //       total += lineTotal;
    //    console.log(total);
    
      //})
      //$('[name="sub_total"]').val(total)
      //$('#sub_total').text(parseFloat(total).toLocaleString('en-US'))
      //var pack_total =  parseFloat(total);
 // var gtotal =  parseFloat(pack_total);
   //   var gt_round = Math.round(gtotal);
     // $('[name="total_amount"]').val(gt_round);
      //$('#gtotal').text(parseFloat(gt_round).toLocaleString('en-US'))
    //}

   function calc_total() {
    var total = 0;

    $('#item-list tbody tr').each(function () {
        var tr = $(this);
        var qty = parseFloat(tr.find('[name^="products["][name$="[qtyvalue]"]').val()) || 0;
        var price = parseFloat(tr.find('[name^="products["][name$="[priceval]"]').val()) || 0;
        var discount = parseFloat(tr.find('[name^="products["][name$="[discountval]"]').val()) || 0;
        var gst = parseFloat(tr.find('[name^="products["][name$="[gstval]"]').val()) || 0;

        var totalWithoutDiscount = qty * price;
        var discountAmount = (totalWithoutDiscount * discount) / 100;
        var totalBeforeGST = totalWithoutDiscount - discountAmount;

        var gstAmt = (totalBeforeGST * gst / 100);
        var totalAmount = totalBeforeGST + gstAmt;

        total += totalAmount;
    });

    $('[name="sub_total"]').val(total.toFixed(2));
    $('#sub_total').text(parseFloat(total).toLocaleString('en-US'));

    var gtotal = parseFloat(total);
    $('#gtotal').text(parseFloat(gtotal).toLocaleString('en-US'));
}

//    function calc_total() {
  //var total = 0;
//var t = $('#total_amount').val();
 // $('#item-list tbody tr').each(function () {
 //   var tr = $(this);
  //var inputField = tr.find('[name="products[' + count + '][total]"]');
//console.log("Input Field Value:", inputField.val());

//var parsedValue = parseFloat(inputField.val()) || 0;
//console.log("Parsed Value:", parsedValue);

//var lineTotal = parsedValue;
//console.log("Final Line Total:", lineTotal);

    
  //  var lineTotal = parseFloat(tr.find('[name="products['+ count +'][total]"]').val()) || 0;
    // console.log('Line Total:', lineTotal);
   // total += lineTotal;
  //});
//total = total + t;
 // $('[name="sub_total"]').val(total);
  //$('#sub_total').text(parseFloat(total).toLocaleString('en-US'));

  //var gtotal = parseFloat(total);
  //$('#gtotal').text(parseFloat(gtotal).toLocaleString('en-US'));
//}

   
    function edit_item(_this) {
      alert("from edit item");
      var t = document.getElementById('item-list');
      var rows = t.rows; //rows collection - https://developer.mozilla.org/en-US/docs/Web/API/HTMLTableElement
      //for (var i=0; i<rows.length; i++) {
      this.onclick = function() {
        if (this.parentNode.nodeName == 'THEAD') {
          return;
        }
        alert("tr");
        var cells = this.cells; //cells collection
        var f1 = document.getElementById('gst');
        var f2 = document.getElementById('product');
        var f3 = document.getElementById('qty');
        var f4 = document.getElementById('price');
        // var f5 = document.getElementById('discount');
        // var f6 = document.getElementById('diff');
        f1.value = cells[1].innerHTML;
        f2.value = cells[2].innerHTML;
        f3.value = cells[3].innerHTML;
        f4.value = cells[4].innerHTML;
        // f5.value = cells[5].innerHTML;
        console.log(f1.value);
        console.log(f2.value);
        console.log(f3.value);
        _this.closest('tr').remove();
        calc_total();

      };
      // }
    }
  </script>


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

<script type="text/javascript">
    $(document).ready(function() {
        $("#center_type").on("change", function() {
            var ctype = $('#center_type').find("option:selected").val();
           
 $.ajax({
            type: 'POST',
            url: 'fetch_packages.php', // PHP script to fetch packages based on the selected consultant
            data: { center_type: ctype },
            success: function (data) {
                $('#product').html(data); // Populate the datalist with fetched package options
            }
        });
  });
        // Trigger change event on page load to apply the logic
        $("#center_type").trigger("change");
    });

</script>

 <script type="text/javascript">
    $(document).ready(function() {
      $("#product_choice").change(function() {

        var packname = $(this).val(); 
        $.ajax({
          url: 'getprice.php',
          Type: "GET",
         data: {
            "packname": packname
          },
          //cache: false,
          success: function(data) {
            
          console.log(data);
               
           var response = JSON.parse(data);
                var cost = response.cost;
                var gst = response.gst;
                var gst_amt = response.gst_amt;
            var net_price = response.net_price;
            var in_ex_gst = response.in_ex_gst;
                // Do something with the cost and gst values
                console.log("Cost: " + cost);
                
                // Update your form fields with the retrieved values
                $("#price").val(cost);
                $("#gst").val(gst); 
            $("#gst_amt").val(gst_amt);
            $("#net_price").val(net_price);
            $("#in_ex_gst").val(in_ex_gst);
                if($("#discount").val() === "")
                {
                  $("#discount").val(0);
                } 
                if($("#qty").val() === "")
                {
                  $("#qty").val(1);
                } 
                // $("#discount").val(0); 
          
          }
        });
      })
    });
  </script>

      <!-- Add this script at the end of your HTML body section -->
<script type="text/javascript">
  
   function rem_item1(_this) {
        var confirmation = confirm("Are you sure you want to delete this invoice?");
        if (confirmation) {
              _this.closest('tr').remove();
      // c--;
      itemno--;
      calc_total();
        }
   }
  
  function rem_item(_this, invoice_item_id) {
    var invoiceId = <?php echo $invoice_id; ?>;
     var confirmation = confirm("Are you sure you want to delete this item?");
    if (confirmation) {
      
        $.ajax({
            type: 'POST',
            url: 'delete-invoice-item.php', // Path to your PHP script
            data: {  invoice_item_id: invoice_item_id,
                invoice_id: invoiceId },
            success: function(response) {
                // If deletion is successful, remove the row from the table
                _this.closest('tr').remove();
                calc_total();
                alert('Item deleted successfully.');
              alert(response);
            },
            error: function() {
                alert('Error deleting item.');
            }
        });
    }
}

  
  //  function deleteInvoice() {
    //    var confirmation = confirm("Are you sure you want to delete this invoice?");
      //  if (confirmation) {
        //    var invoiceId = <?php echo $invoice_id; ?>;
         //   $.ajax({
           //     type: 'POST',
            //    url: 'delete_invoice.php', // Replace with the actual path to your delete script
             //   data: { invoice_id: invoiceId },
               // success: function(response) {
                    // Handle the response, e.g., redirect to a different page
                 //   window.location.href = 'invoices.php';
                //},
                //error: function() {
                  //  alert('Error deleting invoice.');
                //}
            //});
        //}
    //}
</script>
</body>
</html>

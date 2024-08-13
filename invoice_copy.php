
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

<style>
  .form_loader {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  text-align: center;
  color: #000; /* Black color */
  font-size: 24px; /* Icon size */
  z-index: 999;
}

.form_loader i {
  animation: spin 1s infinite linear;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>


</head>
<body class="hold-transition sidebar-mini">
<div id="form_loader" class="form_loader" style="display:none;">
    <i class="fas fa-spinner fa-spin"></i>
     Please wait...While Creating Invoice
  </div>
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
                  <form action="invoicedb.php" method="POST" enctype="multipart/form-data" onsubmit="showFormLoader()">
                    <?php
                    if(isset($_GET['patient_id']))
                    {
                      $patient_id = $_GET['patient_id'];
                      $branch_name = $_GET['branch_name'];
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
                    }
                    ?>
                    <input type="text" name="patient_name" id="pateint_name" value="<?php echo $patient['patient_first_name'] ." " . $patient['patient_last_name']?>" hidden>
                    <input type="text" name="patient_id" id="pateint_id" value="<?php echo $patient['patient_id'];?>" hidden>

                    <div class="row">
                      
                       <div class="col-md-4">
                        <select class="form-control" name="consultant" id="consultant"> 
                         <?php
                                $sql1 = "select * from doctor where branch_name = '$branch_name'";
                                $result1 = $conn->query($sql1);
                                if ($result1->num_rows > 0) {
                                  while ($row1 = mysqli_fetch_assoc($result1)) {
                                ?>
                              <option value="<?php echo $row1["doctor_name"] ?>"><?php echo $row1["doctor_name"] ?></option>
                            <?php
                                  }
                                }
                            ?>
                        </select>

          
                      </div>


                      <div class="col-md-4">
                        <select class="form-control" name="center_type" id="center_type"> 
                          <option  value="wellness" Selected>MJVA Wellness Pvt Ltd</option>
                          <option  value="healthcare" >MJVA healthcare Pvt Ltd</option>
                          
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
                  </tbody>
                  <tfoot>

                    <tr>
                       <th colspan="3" rowspan="2"><textarea class="form-control" name="note" id="note" placeholder="Note"></textarea></th>
                      <th class="text-right" colspan="2">Sub Total</th>
                      <th class="text-right" id="sub_total">0
                        <input type="text" name="sub_total"  value="0" hidden>
                      </th>
                    </tr>
                 
                 <!--    <tr>
                      <th class="text-right" colspan="2">Additional Payable</th>-->
                      <!-- <th class="text-right" id="tax_rate"></th> -->
                     <!-- <th><input type="number" class="form-control" name="pack_price" id="pack_price" value="0" onchange="calc_total();"></th>
                    </tr> -->
                    <tr>
                      <th class="text-right" colspan="2">Grand Total</th>
                      <th class="text-right" id="gtotal">0</th>
                      <input type="hidden" name="total_amount" value="0">
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
                  <script>
function showFormLoader() {
  // Show the overlay
  var overlay = document.createElement("div");
  overlay.id = "overlay";
  overlay.style.position = "fixed";
  overlay.style.top = "0";
  overlay.style.left = "0";
  overlay.style.width = "100%";
  overlay.style.height = "100%";
  overlay.style.backgroundColor = "rgba(0, 0, 0, 0.5)"; // Transparent black
  overlay.style.display = "flex";
  overlay.style.alignItems = "center";
  overlay.style.justifyContent = "center";
  document.body.appendChild(overlay);

  // Show the loader
  document.getElementById('form_loader').style.display = 'block';

  // Simulate form submission delay with a timeout
  setTimeout(function() {
    // Actual form submission logic goes here

    // Hide the loader and overlay
    document.getElementById('form_loader').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
  }, 12000); // Adjust the timeout as needed
}
</script>

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
    count = 1;
    itemno = 1;

    function add_more() {

      
      package = $('#product_choice').val();
     
      qty = parseInt($('#qty').val());
      in_ex_gst = $('#in_ex_gst').val();
//price = parseFloat($('#price').val());
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
var total = ((totalBeforeGST + gstamt).toFixed(2));
      

      // total = parseFloat(price) * parseFloat(qty);
      var html = '<tr><td>' + package + '</td><td>' + qty + '</td><td>' + price + '</td><td>' + discountAmount +' (' + discount + ' %)</td><td>' + gstamt +'('+ gst +' %)</td>'
      +'<td>' + total + '<input type="number" name="itemnum[]" id="itemnumval' + count + '" value="' + itemno + '" hidden/><input  name="packages[]" id="packagesval' + count + '" value="' + package + '" hidden/><input type="number" name="qtyvalue[]" id="qtyvalueval' + count + '" value="' + qty + '" hidden/><input type="number" name="priceval[]" id="priceval' + count + '" value="' + price + '" hidden/><input type="number" name="gstval[]" id="gstval' + count + '" value="' + gst + '" hidden/><input type="number" name="gstamtval[]" id="gstamtval' + count + '" value="' + gstamt + '" hidden/><input type="number" name="discountval[]" id="discountval' + count + '" value="' + discount + '" hidden/><input type="number" name="total[]" id="total' + count + '" value="' + total + '" hidden/></td><td><button class="btn btn-sm btn-outline-danger" type="button" onclick="rem_item($(this))"><i class="fa fa-trash" style="color:red;"></i></button></td></tr>';
      // <td><button class="btn btn-sm btn-outline-info" type="button" onclick="edit_item($(this))"><i class="fa fa-trash" style="color:skyblue;"></i></button></td>
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
      // alert(products[]);
      // alert(itemnum[]);
      // alert(qtyvalue[]);
      calc_total();
      // p= $('#products').val();
      //console.log(p);
      //var input = document.getElementById('products').value;

      // for (var i = 0; i < input.length; i++) {
      //     var a = input[i];
      //     k = k + "products[" + i + "].value= "
      //                        + a.value + " ";
      // }

      //document.getElementById("arrPrint").innerHTML = input;
      // document.getElementById("po").innerHTML = "Output";

    }

    function calc_total() {
      var total = 0;
      var total1 = 0;
      // var tax_rate = $('#tax_rate').val();
      var pack_price = $('#pack_price').val();
      // console.log(tax_rate);
      // var tax_rate = tax_rate / 100;
      $('#item-list tbody tr').each(function() {
        var tr = $(this)
        total += parseFloat(tr.find('[name="total[]"]').val());
        console.log(total1);
        // total += $('#total').val();
        //console.log(total);
        //console.log(tr);
      })
      $('[name="sub_total"]').val(total)
      $('#sub_total').text(parseFloat(total).toLocaleString('en-US'))
      // var pack_total = parseFloat(pack_price) + parseFloat(total);
      var pack_total =  parseFloat(total);

      // var tax = parseFloat(pack_total) * parseFloat(tax_rate);
      var gtotal =  parseFloat(pack_total);
      var gt_round = Math.round(gtotal);
      // alert(gt_round);
      $('[name="total_amount"]').val(gt_round);
      // var tax_amount_round = Math.round(tax);
      // $('[name="tax_amount"]').val(tax_amount_round);
      // $('#tax_amount').text(parseFloat(tax).toLocaleString('en-US'))
      // $('#tax').text(parseFloat(tax).toLocaleString('en-US'))
      $('#gtotal').text(parseFloat(gt_round).toLocaleString('en-US'))
      // var gtotal_round = gtotal.toPrecision();

      // $('[name="total_amount"]').val(gt_round);
      // $('#tax').text();

    }

    function rem_item(_this) {
      _this.closest('tr').remove();
      // c--;
      itemno--;
      calc_total();
    }



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
            // if (type == "healthcare") {
            //     $("#gst").val(0);
            //     $("#gst").prop("readonly", true);
            // } else if (type == "wellness") {
            //     $("#gst").val(18);
            //     $("#gst").prop("readonly", false);
            // }
      

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


//   $(document).ready(function () {
//      $('#center_type').val('wellness');

// fetchPackages(center_type);

//     $('#center_type').change(function () {
//         var selectedcenter_type = $(this).val();
// fetchPackages(center_type);
       
//     });

//      function fetchPackages(center_type) {
//         $.ajax({
//             type: 'POST',
//             url: 'fetch_packages.php', // PHP script to fetch packages based on the selected consultant
//             data: { center_type: center_type },
//             success: function (data) {
//                 $('#product').html(data); // Populate the datalist with fetched package options
//             }
//         });
//     }

// });

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
           var response = JSON.parse(data);
                var cost = response.cost;
                var gst = response.gst;
                var gst_amt = response.gst_amt;
            var net_price = response.net_price;
            var in_ex_gst = response.in_ex_gst;
                // Do something with the cost and gst values
                console.log("Cost: " + cost);
                console.log(data);
                
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

</body>
</html>

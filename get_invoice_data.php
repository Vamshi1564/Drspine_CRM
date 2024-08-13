
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include("config.php");
//date_default_timezone_set('UTC');
error_reporting(E_ALL);
ini_set('display_errors', -1);
//echo date_default_timezone_get();
if (isset($_GET['branch'])) {
   // $branch_name = $_GET['branch'];
  //$fromDate = $_GET['from_date'];
//$toDate = $_GET['to_date'];
  $branch_name = isset($_GET['branch']) ? $_GET['branch'] : 'All';
$fromDate = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$toDate = isset($_GET['to_date']) ? $_GET['to_date'] : '';
 $fromDate1 = date('Y-m-d 00:00:00');  // Start of today
    $toDate1 = date('Y-m-d 23:59:59');  
  
              if(!empty($fromDate) && !empty($toDate))
              {
                 if ($branch_name === "All") {
                $sql = "SELECT 
                            i.id AS invoice_id,
                            i.invoice_code,
                            i.patients_id,
                            a.patient_first_name,
                            i.consultant_name,
                            i.centre_type,
                            i.branch_name,
                            i.sub_total,
                            i.total,
                            i.pending_amt,
                            i.note,
                            i.invoice,
                            i.payment_status,
                          i.created_on AS invoice_created_on,
                            i.created_by AS invoice_created_by
                        FROM invoices i LEFT JOIN drspine_appointment a ON i.patients_id = a.patient_id
                        WHERE i.created_on BETWEEN '$fromDate' AND '$toDate'
                        ORDER BY i.created_on DESC ";
                  }  
              else{
                 $sql = "SELECT 
                            i.id AS invoice_id,
                            i.invoice_code,
                            i.patients_id,
                            a.patient_first_name,
                            i.consultant_name,
                            i.centre_type,
                            i.branch_name,
                            i.sub_total,
                            i.total,
                            i.pending_amt,
                            i.note,
                            i.invoice,
                            i.payment_status,
                           i.created_on AS invoice_created_on,
                            i.created_by AS invoice_created_by
                        FROM invoices i LEFT JOIN drspine_appointment a ON i.patients_id = a.patient_id
                        WHERE i.branch_name = '$branch_name' AND i.created_on BETWEEN '$fromDate' AND '$toDate'
                        ORDER BY i.created_on DESC";
                           }
            } else {
                if($branch_name != "All")
                {
                     $sql = "SELECT 
                            i.id AS invoice_id,
                            i.invoice_code,
                            i.patients_id,
                            a.patient_first_name,
                            i.consultant_name,
                            i.centre_type,
                            i.branch_name,
                            i.sub_total,
                            i.total,
                            i.pending_amt,
                            i.note,
                            i.invoice,
                            i.payment_status,
                           i.created_on AS invoice_created_on,
                            i.created_by AS invoice_created_by
                        FROM invoices i LEFT JOIN drspine_appointment a ON i.patients_id = a.patient_id
                        WHERE i.branch_name = '$branch_name' ORDER BY i.created_on DESC";
                }
                else{
                 
             $sql = "SELECT 
                            i.id AS invoice_id,
                            i.invoice_code,
                            i.patients_id,
                            a.patient_first_name,
                            i.consultant_name,
                            i.centre_type,
                            i.branch_name,
                            i.sub_total,
                            i.total,
                            i.pending_amt,
                            i.note,
                            i.invoice,
                            i.payment_status,
                          i.created_on AS invoice_created_on,
                            i.created_by AS invoice_created_by
                        FROM invoices i LEFT JOIN drspine_appointment a ON i.patients_id = a.patient_id  WHERE i.created_on BETWEEN '$fromDate1' AND '$toDate1' ORDER BY i.created_on DESC ";
                }
  
            }

            $result1 = $conn->query($sql);

// Initialize totals
$totalReceived = 0;
$totalPending = 0;
$grandTotal = 0;
  while ($row1 = $result1->fetch_assoc()) {
        $received = (float)$row1['total'] - (float)$row1['pending_amt'];
        $totalReceived += $received;
        $totalPending += (float)$row1['pending_amt'];
        $grandTotal += (float)$row1['total'];
    }
               
?>
<?php
setlocale(LC_MONETARY, 'en_IN');
  ?>
<!--<div class="col-md-4">-->
  <span><b style="color:red">Pending : </b>₹. <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $totalPending);  ?></span>
  <span><b style="color:blue">Total : </b>₹. <?php echo preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,",$grandTotal) ?></span>
<!--</div>-->

<table id="example1" class="display nowrap">
        <thead>
            <tr>
                <th>Invoice</th>
                <th>Date</th>
                <th>Consultant</th>
              <th>Patient Name</th>
                <th>Added By</th>
                <th>Procedures</th>
                <th>Category</th>
                <th>Received</th>
                <th>Pending</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>  
          <?php
                 $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
              // Assuming $dbDate contains your database date (e.g., "2023-12-26 14:25:22")
$dbTimestamp = $row['invoice_created_on'];;

// Create a DateTime object with the UTC time zone
$dateTimeUTC = new DateTime($dbTimestamp, new DateTimeZone('UTC'));

// Convert the time zone to India Standard Time
$dateTimeIST = $dateTimeUTC->setTimezone(new DateTimeZone('Asia/Kolkata'));

// Format the DateTime object in 12-hour format
$formattedDate = $dateTimeIST->format('Y-m-d h:i:s A');

            ?>
                <tr>
                    <td><a href="manage_invoice.php?patient_id=<?php echo $row['patients_id']?>&branch_name=<?php echo $row['branch_name']?>"><?php echo $row['invoice_code'] ?></a></td>
                    <td><?php echo $formattedDate; ?></td>
                    <td><?php echo $row['consultant_name'] ?></td>
                      <td><a href="view_single_patient_details.php?patient_id=<?php echo $row['patients_id']?>&branch_name=<?php echo $row['branch_name']?>"><?php echo $row['patient_first_name']?></a></td>
                    <td><?php echo $row['invoice_created_by'] ?></td>
                    <td>
                        <?php
                        // Fetch all related products for the current invoice
                        $invoiceId = $row['invoice_id'];
                        $productsSql = "SELECT package FROM invoice_items WHERE invoice_id = $invoiceId";
                        $productsResult = $conn->query($productsSql);

                        $products = [];
                        while ($productRow = $productsResult->fetch_assoc()) {
                            $products[] = $productRow['package'];
                        }

                       // echo implode(', ', $products);
                        ?>
                      <textarea rows="2" style="overflow:auto;width: 250px;height: 45px;" class="form-control" readonly><?php echo implode(', ', $products);?></textarea>
                    </td>
                    <td><?php echo $row['centre_type'] ?></td>
                    <td><?php echo ($row['total'] - $row['pending_amt']) ?></td>
                    <td><?php echo $row['pending_amt'] ?></td>
                    <td><?php echo $row['total'] ?></td>
                </tr>
            <?php
                          
            }




            ?>
        </tbody>
     
    </table>

<?php
}
?>


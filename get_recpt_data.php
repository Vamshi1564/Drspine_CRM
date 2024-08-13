<?php
include("config.php");
error_reporting(E_ALL);
ini_set('display_errors', -1);

if(isset($_GET['branch']))
{
   
    $branch_name = isset($_GET['branch']) ? $_GET['branch'] : 'All';
$fromDate = isset($_GET['from_date']) ? $_GET['from_date'] : '';
$toDate = isset($_GET['to_date']) ? $_GET['to_date'] : '';


?>
<table id="example1">
        <thead>
            <tr>
                <th>Receipt</th>
                <th>Date</th>
                
                <!-- <th>Added By</th> -->
                <th>Pateint</th>
                <th>Invoice</th>
                <th>Payment Mode</th>
                <th>Amount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <!-- Table rows go here -->
        

<?php
     if (!empty($fromDate) && !empty($toDate)) {
        if ($branch_name === "All") {
            $sql = "SELECT r.id as r_id, r.recpt_id as recpt_id, r.invoice_id, r.patient_id, r.pdf_file_path, r.total_amount, r.paid_amount, p.payment_type, r.created_at, p.* FROM receipts r LEFT JOIN payments p ON r.recpt_id = p.receipt_id and r.invoice_id = p.invoice_id WHERE r.created_at BETWEEN '$fromDate' AND '$toDate' ORDER BY r.created_at DESC";
        } else {
            $sql = "SELECT r.id as r_id, r.recpt_id as recpt_id, r.invoice_id, r.patient_id, r.pdf_file_path, r.total_amount, r.paid_amount, p.payment_type, r.created_at, p.* FROM receipts r LEFT JOIN payments p ON r.recpt_id = p.receipt_id and r.invoice_id = p.invoice_id LEFT JOIN invoices i ON i.invoice_code = r.invoice_id WHERE i.branch_name = '$branch_name' AND r.created_at BETWEEN '$fromDate' AND '$toDate' ORDER BY r.created_at DESC";
        }
    } else {
        if ($branch_name != "All") {
            $sql = "SELECT r.id as r_id, r.recpt_id as recpt_id, r.invoice_id, r.patient_id, r.pdf_file_path, r.total_amount, r.paid_amount, p.payment_type, r.created_at, p.* FROM receipts r LEFT JOIN payments p ON r.recpt_id = p.receipt_id and r.invoice_id = p.invoice_id LEFT JOIN invoices i ON i.invoice_code = r.invoice_id WHERE i.branch_name = '$branch_name' ORDER BY r.created_at DESC";
        } else {
            $sql = "SELECT r.id as r_id, r.recpt_id as recpt_id, r.invoice_id, r.patient_id, r.pdf_file_path, r.total_amount, r.paid_amount, p.payment_type, r.created_at, p.* FROM receipts r LEFT JOIN payments p ON r.recpt_id = p.receipt_id and r.invoice_id = p.invoice_id LEFT JOIN invoices i ON i.invoice_code = r.invoice_id ORDER BY r.created_at DESC";
        }
    }
   
$result = $conn->query($sql);

// Create an empty array to store grouped invoice data


// Group the data by invoice code
while ($row = $result->fetch_assoc()) {
   
   // Create a new entry for the invoice code if it doesn't exist
   
?>

 <tr>
                <td><?php echo $row['recpt_id'];?></td>
                <td><?php echo date('Y-m-d g:i A', strtotime($row['created_at'])); ?></td>
                <td><?php echo $row['patient_id']?></td>
                <td><?php echo $row['invoice_id']?></td>
                <td><?php echo $row['payment_type']?></td>
                <td><?php echo $row['paid_amount']?></td>
               
                <td><?php echo $row['total_amount']?></td>
            </tr>
<?php
}

?>


</tbody>
    <tfoot>
            <tr>
                <th colspan="7"></th>
               
            </tr>
          </tfoot>
    </table>
    <?php      
}

?>
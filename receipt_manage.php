<?php
include("config.php");
if(isset($_GET['patient_id']) && isset($_GET['invoice_id']))
{
    $patient_id = $_GET['patient_id'];
    $invoice_id = $_GET['invoice_id'];

    // Fetch data from the receipts and payments tables based on patient_id and invoice_id
    $sql = "SELECT r.id as recpt_id, r.total_amount, r.pdf_file_path, r.created_at, 
                   p.id as payment_id, p.payment_type, p.amount, p.bank_name, 
                   p.cheque_number, p.transaction_id, p.paid_using, p.created_at as payment_created_at
            FROM receipts r
            LEFT JOIN payments p ON r.id = p.receipt_id
            WHERE r.patient_id = '$patient_id' AND r.invoice_id = '$invoice_id'";

    $result = $conn->query($sql);

    while ($row = $result->fetch_assoc()) {
        $recpt_id = $row['recpt_id'];
        $total_amount = $row['total_amount'];
        $pdf_file_path = $row['pdf_file_path'];
        $created_at = $row['created_at'];

        // Payment details
        $payment_id = $row['payment_id'];
        $payment_type = $row['payment_type'];
        $amount = $row['amount'];
        $bank_name = $row['bank_name'];
        $cheque_number = $row['cheque_number'];
        $transaction_id = $row['transaction_id'];
        $paid_using = $row['paid_using'];
        $payment_created_at = $row['payment_created_at'];

        // Display receipt and payment details here as needed
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="row ml-0 mr-0" style="background: lightgray; border-top-left-radius: 2px; border-top-right-radius: 2px;">
                    <div class="col-md-6">
                        <h4 class="p-1 m-0">Receipt ID: <?php echo $recpt_id; ?></h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="<?php echo $pdf_file_path; ?>" target="_blank" style="float:right;"><i class="fa fa-print ml-4 p-1"></i></a>
                    </div>
                </div>
                <table id="example1" class="mt-0 table table-bordered jsgrid-table" style="box-shadow: 1px 2px 4px 0px #8080804f; margin-top: 0px !important; margin-bottom: 15px !important;">
                    <tr>
                        <th>Receipt ID</th>
                        <th>Total Amount</th>
                        <th>PDF File Path</th>
                        <th>Created At</th>
                        <th>Payment Type</th>
                        <th>Amount</th>
                        <th>Bank Name</th>
                        <th>Cheque Number</th>
                        <th>Transaction ID</th>
                        <th>Paid Using</th>
                        <th>Payment Created At</th>
                    </tr>
                    <tr>
                        <td><?php echo $recpt_id; ?></td>
                        <td><?php echo $total_amount; ?></td>
                        <td><?php echo $pdf_file_path; ?></td>
                        <td><?php echo $created_at; ?></td>
                        <td><?php echo $payment_type; ?></td>
                        <td><?php echo $amount; ?></td>
                        <td><?php echo $bank_name; ?></td>
                        <td><?php echo $cheque_number; ?></td>
                        <td><?php echo $transaction_id; ?></td>
                        <td><?php echo $paid_using; ?></td>
                        <td><?php echo $payment_created_at; ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <?php
    }
}
else
{
    ?>
    <div><table>
        <tr>
            <td>No records found</td>
        </tr>
    </table></div>
    <?php
}
?>

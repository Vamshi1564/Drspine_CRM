<?php
include("config.php");

if (isset($_GET['id']) && isset($_GET['invoice_id'])) {
    $invoiceId = $_GET['id'];
    $invoiceCode = $_GET['invoice_id'];
    $branch_name = $_GET['branch_name'];
  $pt_id = $_GET['pt_id'];

    // Perform the deletion
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    try {
        // Delete records from the invoice_items table
        $stmt_items = $conn->prepare("DELETE FROM invoice_items WHERE invoice_id = ?");
        $stmt_items->bind_param("i", $invoiceId);
        if (!$stmt_items->execute()) {
            throw new Exception($stmt_items->error);
        }
        $stmt_items->close();

        // Delete records from the invoices table
        $stmt_invoices = $conn->prepare("DELETE FROM invoices WHERE id = ? AND invoice_code = ?");
        $stmt_invoices->bind_param("is", $invoiceId, $invoiceCode);
        if (!$stmt_invoices->execute()) {
            throw new Exception($stmt_invoices->error);
        }
        $stmt_invoices->close();

        // Check if any rows were affected
        $rowsAffected = $conn->affected_rows;
        echo $rowsAffected;
        
        if ($rowsAffected > 0) {
           ?>
            <script>
                alert("No records deleted. Invoice not found.");
                window.location.href = "manage_invoice.php?patient_id=<?php echo $pt_id?>&branch_name=<?php echo $branch_name; ?>";
            </script>
            <?php
       
        } else {
          ?>
            <script>
                alert("Invoice and related records deleted successfully.");
                window.location.href = "manage_invoice.php?patient_id=<?php echo $pt_id?>&branch_name=<?php echo $branch_name; ?>";
            </script>
            <?php
            
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn->close();
    }
} else {
    echo "Invalid request. Please provide both 'id' and 'invoice_id' parameters.";
}
?>

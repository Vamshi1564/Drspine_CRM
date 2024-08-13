<?php
// Include your database connection file or establish a connection here
// Example: include('db_connection.php');
include("config.php");
// Check if the invoice_id is set in the URL
if (isset($_GET['id']) && isset($_GET['recpt_id'])) {
    $r_id = $_GET['id'];
    $recpt_id = $_GET['recpt_id'];
$branch_name = $_GET['branch_name'];
  $patient_id = $_GET['patient_id'];
    // Perform the deletion
   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

   
        // Delete records from the invoice_items table
        $stmt = $conn->prepare("DELETE FROM receipts WHERE id = ? AND recpt_id = ?");
        $stmt->bind_param("is", $r_id,$recpt_id);
        $stmt->execute();
        $stmt->close();

        // Delete records from the invoices table
       // $stmt = $conn->prepare("DELETE FROM invoices WHERE id = ? AND invoice_code = ?");
        //$stmt->bind_param("is", $invoiceId, $invoiceCode);
        //$stmt->execute();
        //$stmt->close();

        // Check if any rows were affected
        $rowsAffected = $conn->affected_rows;

        if ($rowsAffected > 0) {
          ?>
<script>
alert("Invoice and related records deleted successfully.");
  window.location.href="manage_invoice.php?patient_id=<?php echo $patient_id?>&branch_name=<?php echo $branch_name; ?>";
                        
</script>
<?php
        } else {
            echo "No records deleted. Invoice not found.";
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

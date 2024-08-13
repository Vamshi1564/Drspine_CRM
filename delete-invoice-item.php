<?php

include("config.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['invoice_id'])) {
   $invoice_item_id = $_POST['invoice_item_id'];
    $invoice_id = $_POST['invoice_id'];
  
    // Perform the deletion query
    $deleteSql = "DELETE FROM invoice_items WHERE id = '$invoice_item_id' AND invoice_id = '$invoice_id'";
    $result = $conn->query($deleteSql);
echo $deleteSql;
    if ($result) {
        // You can add additional logic or response if needed
        echo 'Invoice deleted successfully.';
    } else {
        echo 'Error deleting invoice.';
    }
} else {
    echo 'Invalid request.';
}
?>

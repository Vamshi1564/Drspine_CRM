<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start(); 
if(!isset($_SESSION['email']) && $_SESSION['ROLE']!='1')
{
   header("Location:login.php");
}
else
{
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
include("config.php");
  include("fpdf/fpdf.php");
 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input
    $invoice_id = $conn->real_escape_string($_POST['invoice_id']);
    $invoice_code = $conn->real_escape_string($_POST['invoice_code']);
    $patient_id = $conn->real_escape_string($_POST['patient_id']);
    $consultant = $conn->real_escape_string($_POST['consultant']);
    $center_type = $conn->real_escape_string($_POST['center_type']);
    $branch_name = $conn->real_escape_string($_POST['branch_name']);
    $sub_total = $conn->real_escape_string($_POST['sub_total']);
    $total_amount = $conn->real_escape_string($_POST['total_amount']);
    $note = $conn->real_escape_string($_POST['note']);

    $branch_admin_name = $_SESSION['mname'];
  
    // ... other fields as needed

    // Begin transaction
    $conn->begin_transaction();
  
   $sql = "SELECT * FROM drspine_appointment WHERE patient_id = '$patient_id'"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        $p_ph_no = $patient['contact_no'];
        $c_email = $patient['email_address'];

    } 

  class PDF extends FPDF{
    function plot_table($widths, $lineheight, $table, $border, $aligns=array(), $fills=array(), $links=array()){
        $func = function($text, $c_width){
            $len=strlen($text);
            $twidth = $this->GetStringWidth($text);
            $split = 0;
if ($twidth != 0) {
     $split = floor($c_width * $len / $twidth);
}
            // $split = floor($c_width * $len / $twidth);
            $w_text = explode( "\n", wordwrap( $text, $split, "\n", true));
            return $w_text;
        };
        foreach ($table as $line){
            $line = array_map($func, $line, $widths);
            $maxlines = max(array_map("count", $line));
            foreach ($line as $key => $cell){
                $x_axis = $this->getx();
                $height = 0;
if (count($cell) != 0) {
    $height = $lineheight * $maxlines / count($cell);
}
                // $height = $lineheight * $maxlines / count($cell);
                $len = count($line);
                $width = (isset($widths[$key]) === TRUE ? $widths[$key] : $widths / count($line));
                $align = (isset($aligns[$key]) === TRUE ? $aligns[$key] : '');
                $fill = (isset($fills[$key]) === TRUE ? $fills[$key] : false);
                $link = (isset($links[$key]) === TRUE ? $links[$key] : '');
                foreach ($cell as $textline){
                    $this->cell($widths[$key],$height,$textline,0,0,$align,$fill,$link);
                    $height += 2 * $lineheight * $maxlines / count($cell);
                    $this->SetX($x_axis);
                }
                if($key == $len - 1){
                    $lbreak=1;
                }
                else{
                    $lbreak = 0;
                }
                $this->cell($widths[$key],$lineheight * $maxlines, '',$border,$lbreak);
            }
        }
    }
}

   date_default_timezone_set('Asia/Kolkata');
$date1 =  date("d-m-Y");
  
$pdf=new PDF('P','mm','A4');
$file_name = md5(rand()) . '.pdf';

$pdf->AddPage();
$pdf->SetFont("Arial","",16);

$pdf->SetDrawColor(221,221,221,1);
// $pdf->SetFillColor(51, 184, 255);
$pdf->SetFillColor(113, 163, 244 );
$pdf->Cell(0,10,"Invoice",0,1,'C',true);


$pdf->Ln(6);
$pdf->Image('dist/img/drspine_logo.png', 80, 20, 50, 22); // Adjust x, y, width, and height as needed
$pdf->Ln(20);
$pdf->SetFont("Arial","",11);

$pdf->Cell(140,6,"Dr Spine Chiropractic Clinic's",0,0,'L');
$pdf->Cell(0,6,"contact us:  + 91 75 5070 5070",0,1,'L');
$pdf->Cell(140,6,"No. 302, 54, The Planet Whitefield Main Road",0,0,'L');
$pdf->Cell(0,6,"Email: Jay@drspine.in",0,1,'L');
$pdf->Cell(140,6,"Brooke Bond 1 Cross, Varthur,Narayanappa Garden,",0,0,'L');
$pdf->Cell(0,6,"Website - drspine.in",0,1,'L');
$pdf->Cell(0,6,"Whitefield, Bengaluru, Karnataka - 560066",0,1,'L');
$pdf->Cell(0,6,"GST- 29AAPCM1431P1ZV",0,1,'L');
$pdf->Ln(4);
$pdf->SetFont("Arial","",12);
// $pdf->SetDrawColor(221,221,221,1);
$pdf->SetDrawColor(0,0,0,1);
$pdf->SetFillColor(0, 0, 0);

// $pdf->SetFillColor(113, 163, 244 );
$pdf->Cell(0,0,"",0,1,'C',true);
// $pdf->SetLineWidth(2);
$pdf->Ln(3);
// $pdf->Cell(15,10,"Buyer :",0,0);
//$w= $pdf->GetStringWidth($customer_name)+6;
// $pdf->SetX((210-$w)/2);
// $pdf->Cell(120,10,$customer_name,0,0);


$table = array(array($patient_name, $p_ph_no,$date1));
$lineheight = 6;
$fontsize = 10;
$widths = array(90,50,35);
$border=0;
$pdf->plot_table($widths, $lineheight, $table,$border);


// $pdf->Cell(18,10,"Date: ",0,0);
// $pdf->Cell(0,10,$date1,0,1);
$pdf->Ln(3);

$pdf->SetDrawColor(0,0,0,1);
$pdf->SetFillColor(0, 0, 0);
$pdf->Cell(0,0,"",0,0,'C',true);
$pdf->Ln(2);
$pdf->Cell(140,10,"Invoice By : $consultant",0,0);
// $pdf->Cell(86,10,$invoice_code,0,0);
$pdf->Cell(0,10,"Invoice No : $invoice_code ",0,0);
// $pdf->Cell(86,10,$invoice_code,0,0);
// $pdf->Cell(15,10,"Date: ",0,0);
// $pdf->Cell(0,10,$date1,0,1);

$pdf->Ln(20);
$pdf->SetFont("Arial","",10);
$pdf->SetTextColor(0,0,0,1);
$pdf->SetDrawColor(221,221,221,1);
$pdf->SetLineWidth(0);

// $pdf->Cell(10,10,"Sl.No.",1,0);
// $pdf->CellFitScale(70,10,"products",1,0,'',1);

// $pdf->CellFitScale(70,10,"proddesc",1,0,'',1);
$pdf->Cell(78,10,"Items",1,0,'L');
 $pdf->Cell(17,10,"Quantity",1,0,'L');
$pdf->Cell(19,10,"Price",1,0,'C');
$pdf->Cell(20,10,"GST",1,0,'C');
$pdf->Cell(20,10,"Discount",1,0,'C');
$pdf->Cell(27,10,"Total",1,1,'C');

  
    try {
        // Update invoices table
       

        // Delete old invoice_items entries
        $delete_items_sql = "DELETE FROM invoice_items WHERE invoice_id=?";
        $stmt_delete = $conn->prepare($delete_items_sql);
        $stmt_delete->bind_param("i", $invoice_id);
        $stmt_delete->execute();

        // Insert new invoice_items entrie
        $insert_item_sql = "INSERT INTO invoice_items (invoice_id, package, qty, price, gst, discount, total) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($insert_item_sql);
$total1 =0;
        foreach ($_POST['products'] as $product) {
            // Sanitize each product field
            $package = $conn->real_escape_string($product['packages']);
            $qty = $conn->real_escape_string($product['qtyvalue']);
            $price = $conn->real_escape_string($product['priceval']);
            $gst = $conn->real_escape_string($product['gstval']);
            $discount = $conn->real_escape_string($product['discountval']);
            $total = $conn->real_escape_string($product['total']);
          $gstamtval = $conn->real_escape_string($product['gstamtval']);

            $stmt_insert->bind_param("issssss", $invoice_id, $package, $qty, $price, $gst, $discount, $total);
            $stmt_insert->execute();
          $total1 +=$total;
          
          $table = array(array($package, $qty, $price,$gstamtval . ' (' . $gst . '%)', $discount, $total));
          $lineheight = 8;
$fontsize = 10;
$widths = array(78,17,19,20,20,27);
$aligns = array('L','L','C','C','C','C');
$border=1;
$pdf->plot_table($widths, $lineheight, $table,$border,$aligns);


        }
 
      $pdf->Cell(151,10,"Grand Total",1,0,'C');
$pdf->Cell(30,10,$total1,1,1,'C');

      $pdf->Ln(20);
$pdf->Cell(140,6,"",0,0,'L');
$pdf->Cell(0,6,"Dr Spine",0,1,'L');
$pdf->Cell(140,6,"",0,0,'L');
$pdf->Cell(0,6,"Electronically Signed by:",0,1,'L');
$pdf->Cell(140,6,"",0,0,'L');
$pdf->Cell(0,6,"Dr. Dr Jay",0,1,'L');
$pdf->Cell(140,6,"",0,0,'L');
$pdf->Cell(0,6,"(Reg No.: 36675)",0,1,'L');
$pdf->Cell(140,6,"",0,0,'L');
$pdf->Cell(0,6,"Chiropractor",0,1,'L');

   ob_end_clean();
      $separator = md5(time());

// carriage return type (we use a PHP end of line constant)
$eol = PHP_EOL;

// attachment name
$filename = "pdf/".$file_name;


// encode data (puts attachment in proper format)
 $pdfdoc = $pdf->Output('S');
 $pf = $pdf->Output();

file_put_contents($filename, $pdfdoc);
$attachment = chunk_split(base64_encode($pdfdoc));


       $update_invoice_sql = "UPDATE invoices SET consultant_name=?, centre_type=?, branch_name=?, sub_total=?, total=?, pending_amt=?,note=?,invoice=?,payment_status=? WHERE id=?";
        $totalValue = $total1;
      $ps ='Due';

$stmt_update = $conn->prepare($update_invoice_sql);
$stmt_update->bind_param("sssssssssi", $consultant, $center_type, $branch_name, $sub_total, $totalValue, $totalValue, $note, $filename, $ps, $invoice_id);
$stmt_update->execute();
        // Commit transaction
        $conn->commit();

        // Redirect or inform the user of success
      ?>
           <script>
     window.location="manage_invoice.php?patient_id=<?php echo $patient_id?>&branch_name=<?php echo $branch_name;?>";
        alert("Successfully Updated Invoice");
    </script> 
<?php
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
       echo '<script>alert("Email sending failed. Error: '.$mail->ErrorInfo.'")</script>';?>
      ?>
          <script>
      window.location="manage_invoice.php?patient_id=<?php echo $patient_id?>&branch_name=<?php echo $branch_name;?>";

    </script> 
<?php
      
    }

    $stmt_update->close();
    $stmt_delete->close();
    $stmt_insert->close();
    $conn->close();
}
?>

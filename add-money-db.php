<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
  include("config.php");
  include("fpdf/fpdf.php");

 if (isset($_POST['add_cash_payment']) || isset($_POST['add_card_payment']) || isset($_POST['add_online_payment']) || isset($_POST['add_cheque_payment'])) {
        $payment_type = $_POST['payment_type'];
        $amount = $_POST['cash_amount'] ?? $_POST['card_amt'] ?? $_POST['online_amt'] ?? $_POST['cheque_amt'] ?? null;
        $bank_name = $_POST['bank_name'] ?? null;
        $cheque_number = $_POST['cheque_number'] ?? null;
        $transaction_id = $_POST['transaction_id'] ?? null;
        $paid_by = $_POST['paid_by'] ?? null;

        $cardNumber = $_POST['cardnumber'] ?? null;
        $invoice_id =$_POST['invoice_id'];
        $patient_id = $_POST['patient_id'];
$invoice_pid = $_POST['invoice_pid'];
        // Validate and sanitize input data as needed

$sql = "SELECT * FROM drspine_appointment WHERE patient_id = '$patient_id'"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
        $p_ph_no = $patient['contact_no'];
          $c_email = $patient['email_address'];
          $patient_name = $patient['patient_first_name'] ." " .$patient['patient_last_name'];
    } 


 date_default_timezone_set('Asia/Kolkata');
$date1 =  date("d-m-Y");


$result1=mysqli_query($conn,"select id from receipts where id=(select max(id) from receipts)");
  if($row1=mysqli_fetch_array($result1))
  {
    $id=$row1['id']+1;
    $i=$row1['id'];
    $s=preg_replace("/[^0-9]/", '', $i);
    $receipt_code="RCPT0".($s+1);
  }
  else
  {
    $receipt_code="RCPT0".(1); 
  }


$res1=mysqli_query($conn,"select * from invoices where invoice_code = '$invoice_id'");
  if($row2=mysqli_fetch_array($res1))
  {
    $pending_amt = $row2['pending_amt'];  
 $total_amount = $row2['total'];
 $branch_name = $row2['branch_name'];

  }
  $total_p = $total_amount - $pending_amt;
  $total_paid_amount = $amount + $total_p;
  // if($pending_amt === 0 || $amount === $total_amount )
  //           {
  //               $payment_status = "Paid";
               
  //           }
  //           else{
               
  //               $payment_status = "Due";
  //           }

// if($pending_amt > 0){
// $due_amount = $pending_amt - $amount;
// }elseif($pending_amt === 0)
// {
//     $due_amount = $total_amount - $amount;
// }

$due_amount = $total_amount - $total_paid_amount;

// Determine the payment status
if ($due_amount === 0) {
    $payment_status = "Paid";
} else {
    $payment_status = "Due";
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

$pdf=new PDF('P','mm','A4');
$file_name = md5(rand()) . '.pdf';

$pdf->AddPage();
$pdf->SetFont("Arial","",16);

$pdf->SetDrawColor(221,221,221,1);
// $pdf->SetFillColor(51, 184, 255);
$pdf->SetFillColor(113, 163, 244 );
$pdf->Cell(0,10,"Receipt",0,1,'C',true);


$pdf->Ln(6);
$pdf->Image('dist/img/drspine_logo.png', 80, 20, 50, 22); // Adjust x, y, width, and height as needed
$pdf->Ln(20);
$pdf->SetFont("Arial","",11);

$pdf->Cell(140,6,"ASIAN INSTITUTE OF SCOLIOSIS LLP,",0,0,'L');
$pdf->Cell(0,6,"contact us:  + 91 75 5070 5070",0,1,'L');
$pdf->Cell(140,6,"Corporate Office: # 385, 5th Floor, Opp Star Bucks,",0,1,'L');
$pdf->Cell(0,6,"Email: Jay@drspine.in",0,1,'L');
$pdf->Cell(140,6,"RMV 2nd Stage, 2nd Block, 80 Ft Road,",0,1,'L');
$pdf->Cell(0,6,"Website - drspine.in",0,1,'L');
$pdf->Cell(140,6,"Sanjaynagar, Bengaluru - 560 094",0,1,'L');
$pdf->Cell(140,6,"GST No: 29ACBFA1674R1ZU",0,1,'L');
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
// $pdf->Ln(3);

// $pdf->SetDrawColor(0,0,0,1);
// $pdf->SetFillColor(0, 0, 0);
// $pdf->Cell(0,0,"",0,0,'C',true);
$pdf->Ln(4);
$pdf->Cell(140,10,"Received with thanks, amount of $amount.00 INR towards following",0,0);
// $pdf->Cell(86,10,$invoice_code,0,0);
$pdf->Cell(0,10,"Receipt ID : $receipt_code ",0,0);

$pdf->Ln(3);

// $pdf->SetDrawColor(0,0,0,1);
// $pdf->SetFillColor(0, 0, 0);
// $pdf->Cell(0,0,"",0,0,'C',true);
$pdf->Ln(2);
$pdf->Cell(140,10,"",0,0);
// $pdf->Cell(86,10,$invoice_code,0,0);
$pdf->Cell(0,10,"Invoice No : $invoice_id ",0,0);
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
// $pdf->Cell(78,10,"Items",1,0,'L');
//  $pdf->Cell(19,10,"Quantity",1,0,'L');
// $pdf->Cell(19,10,"Price",1,0,'C');
// $pdf->Cell(15,10,"GST",1,0,'C');
// $pdf->Cell(20,10,"Discount",1,0,'C');
// $pdf->Cell(30,10,"Total",1,1,'C');





$pdf->Ln(10);
// $pdf->SetFont("Arial", "B", 12);
// $pdf->Cell(190, 10, "Invoice Items", 1, 1, 'C');

$pdf->SetFont("Arial", "", 10);
$pdf->Cell(90, 10, "Items", 1, 0, 'C');
$pdf->Cell(18, 10, "Quantity", 1, 0, 'C');
$pdf->Cell(18, 10, "Price", 1, 0, 'C');
$pdf->Cell(18, 10, "GST", 1, 0, 'C');
$pdf->Cell(16, 10, "Discount", 1, 0, 'C');
//$pdf->Cell(12, 10, "Paid",1,0,'C');
//$pdf->Cell(12, 10, "Due",1,0,'C');
$pdf->Cell(30, 10, "Total", 1, 1, 'C');

// $invoice_id = $_POST['invoice_id']; // Assuming you get the invoice ID from your form data

// Fetch invoice items from the database
$itemsQuery = "SELECT * FROM invoice_items WHERE invoice_id = '$invoice_pid'";

$itemsResult = $conn->query($itemsQuery);

if ($itemsResult->num_rows > 0) {
    while ($row = $itemsResult->fetch_assoc()) {
        $itemName = $row['package'];
        $quantity = $row['qty'];
        $price = $row['price'];
        $gst = $row['gst'];
        $discount = $row['discount'];
        $total = $row['total'];

        $table = array(array($itemName, $quantity, $price, $gst, $discount, $total));
        $lineheight = 8;
        $fontsize = 10;
        $widths = array(90, 18, 18, 18,16,30);
        $aligns = array('L', 'C', 'C', 'C', 'C','C');
        $border = 1;
        $pdf->plot_table($widths, $lineheight, $table, $border, $aligns);
    }
}

//HERE I want to deisplay invoice items in table format
$pdf->Ln(10);
   $pdf->SetFont("Arial", "B", 12);
$pdf->Cell(140,10,"Mode of Payment : $payment_type",0,0);
$pdf->Cell(50,10,"Payment Status : $payment_status ",0,1);
$pdf->Cell(60,10,"Total Amount : $total_amount",0,0);
$pdf->Cell(60,10,"Paid amount : $amount ",0,0);
$pdf->Cell(0,10,"Due amount : $due_amount ",0,0);


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
        // Insert payment data into the payments table

         $insertPaymentSQL = "INSERT INTO payments (receipt_id,invoice_id, payment_type, amount,paid_amount,due_amount, bank_name,cardNumber, cheque_number, transaction_id, patient_id,paid_using)
                             VALUES ('$receipt_code','$invoice_id', '$payment_type', '$total_amount','$amount','$due_amount', '$bank_name','$cardNumber', '$cheque_number', '$transaction_id', '$patient_id','$paid_by')";

        if ($conn->query($insertPaymentSQL) === TRUE) {
            

          echo $updatePaymentStatusSQL = "UPDATE invoices SET payment_status = '$payment_status', pending_amt = '$due_amount' WHERE invoice_code = '$invoice_id'";

        if ($conn->query($updatePaymentStatusSQL) === TRUE) {


            // echo '<script>alert("Payment was successful")</script>';
       

        ob_end_clean();
        $separator = md5(time());

        $eol = PHP_EOL;

// attachment name
$filename = "Receipt/".$file_name;

 $pdfdoc = $pdf->Output('S');
 //$pf = $pdf->Output();


file_put_contents($filename, $pdfdoc);
$attachment = chunk_split(base64_encode($pdfdoc));




// Create a new PHPMailer instance
$mail = new PHPMailer;

// SMTP Configuration
$mail->isSMTP();
$mail->Host = 'smtp.titan.email';
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'ssl';
$mail->Username = 'bhagath.koduri@iiiqbets.com';
$mail->Password = 'Bhagath@123$';

// Email content
$mail->setFrom('bhagath.koduri@iiiqbets.com', 'Dr Spine Admin');
// $mail->addAddress('soumyacn16@gmail.com', 'Dr Spine Admin');
$mail->addAddress($c_email, 'Dr Spine');

$mail->Subject = 'Receipt From Dr Spine';
$mail->isHTML(true); // Set email format to HTML

$mail->Body = '<table width="100%" style="background-color:#dadada;border-collapse:collapse;border-spacing:0;border-collapse:collapse;border-spacing:0">
<tbody><tr>
<td align="center">
<table width="682" style="border-collapse:collapse;border-spacing:0">

<tbody><tr class="m_-1958935385513098443header">
<td bgcolor="#eeeeee"><table width="100%" border="0" style="border-collapse:collapse;border-spacing:0">
<tbody><tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:left" height="12">&nbsp;</td>
</tr>
<tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:left;border-bottom:3px solid #2f94d7" height="18">&nbsp;</td>
</tr>
</tbody></table></td>
</tr>


<tr><td bgcolor="#ffffff"> 

<table width="100%" border="0" style="border-collapse:collapse;border-spacing:0">
<tbody><tr>
<td width="20" style="font-size:0;line-height:0">&nbsp;</td>
<td width="640" style="font-size:0;line-height:0">

<table width="100%" border="0" style="border-collapse:collapse;border-spacing:0">
<tbody><tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:left" height="15">&nbsp;</td>
</tr>
<tr>
<td style="background-color:#f8f8f8;border:1px solid #ebebeb"><table width="100%" border="0" style="border-collapse:collapse;border-spacing:0">
<tbody><tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:left" height="15">&nbsp;</td>
</tr>
<tr>
<td style="margin:0;color:#1e4a7b;font-size:20px;line-height:24px;font-family:Arial,Helvetica,sans-serif;font-style:normal;font-weight:normal;text-align:center">
Greetings from Dr spine!!!!</td>
</tr><tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:left" height="5">&nbsp;</td>
</tr></tbody></table></td></tr></tbody></table>

<table width="100%" border="0" style="border-collapse:collapse;border-spacing:0">
<tbody><tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:left" height="20">&nbsp;</td>
</tr>
<tr>
<td style="vertical-align:top;margin:0;padding:0;font-size:16px;color:#231f20;line-height:24px;font-family:Arial,Helvetica,sans-serif;font-weight:normal;text-align:left">Dear '. $patient_name .' ,
</td></tr>
<tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:left" height="20">&nbsp;</td>
</tr>
<tr>
<td style="margin:0;padding:0;font-size:16px;color:#231f20;line-height:24px;text-align:center;font-family:Arial,Helvetica,sans-serif;font-weight:normal">

<div style="text-align:left"></div><div style="text-align:left"><span style="background-color:transparent">
Please find the attached Receipt. If you have any queries please feel free to contact.</span>

</div>
</td>
</tr>
<tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:left" height="20">&nbsp;</td>
</tr>
<tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:left" height="20">&nbsp;</td>
</tr>
<tr>
<td style="margin:0;padding:0;font-size:16px;color:#231f20;line-height:21px;font-family:Arial,Helvetica,sans-serif;font-weight:normal">Regards,<br><span class="il">Dr spine</span> Team</td>
</tr>
<tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:left" height="10">&nbsp;</td>
</tr>
<tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:left" height="10">&nbsp;</td>
</tr>
</tbody></table>

</td>
<td width="20" style="font-size:0;line-height:0">&nbsp;</td>
</tr>
</tbody></table></td></tr>


<tr>
<td bgcolor="#eeeeee"><table width="100%" border="0" style="border-collapse:collapse;border-spacing:0">
<tbody><tr>
<td width="35">&nbsp;</td>
<td width="557"><table width="100%" border="0" style="border-collapse:collapse;border-spacing:0">
<tbody><tr>
<td><table width="100%" border="0" style="border-collapse:collapse;border-spacing:0">
<tbody><tr>
<td style="line-height:0;font-size:0;vertical-align:top;padding:0px;text-align:center" height="25">&nbsp;</td>
</tr>
</tbody></table></td>
</tr>


</tbody></table></td>
<td width="35">&nbsp;</td>
</tr>
</tbody></table></td>
</tr>

</tbody></table></td>
</tr>
</tbody></table>';

// Attachment
// $filename = "pdf/" . $file_name;
$mail->addAttachment($filename, $file_name); // Add attachment

 echo $sql3="INSERT INTO receipts(recpt_id,patient_id,invoice_id,total_amount,paid_amount,pdf_file_path) VALUES ('$receipt_code','$patient_id','$invoice_id','$total_amount','$amount','$filename')";

  if ($conn->query($sql3) === TRUE) 
          {
            if ($mail->send())
            {
            echo '<script>alert("succesfully generated Receipt")</script>';
            ?>
            <script>window.location= "manage_receipts.php?patient_id=<?php echo $patient_id;?>&branch_name=<?php echo $branch_name;?>"</script>
            <?php
 }
            else
            {
              echo '<script>alert("Email sending failed. Error: '.$mail->ErrorInfo.'")</script>';
  echo "<script type='text/javascript'> window.location ='manage_receipts.php?patient_id=$patient_id&branch_name=$branch_name'; </script>";
   
            }
          }
      // }
          else

          {
            //echo "Error adding payment: " . $conn->error; 
             echo '<script>alert("payment Detials not inserted. Error: '.$conn->error.'")</script>';
  echo "<script type='text/javascript'> window.location ='add-money.php?patient_id=$patient_id&invoice_code=$invoice_code'; </script>";
   
          }

           } else {
            echo "Error updating payment status: " . $conn->error;
        }
           
        } else {
           
            echo "Error adding payment: " . $conn->error;
           
        }
    }
?>
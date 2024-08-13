<?php
//echo '<script>alert("helooo grom paroduct cat")</script>';
session_start();
// if(isset($_SESSION['ROLE']) && $_SESSION['ROLE']!='1'){
//     header('location:news.php');
//     die();
// }

if(!isset($_SESSION['email'])){
   header("Location:login.php");
}
else
{
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
include_once("config.php");
if($_GET['packname']) {
	$pcat=$_GET['packname'];
		 	
		$sql="select * from  manage_packages where pack_name = '$pcat' ";
							$result=$conn->query($sql);
							if($result->num_rows>0)
							{
								
								 if($row = mysqli_fetch_assoc($result)) 
								 {
								 	
								 	$cost= $row["cost"];
								 	$gst= $row["GST"];
                                   $gst_amt = $row["gst_amt"];
                                   $net_price = $row["net_price"];
                                   $in_ex_gst = $row["in_ex_gst"];
								 	
									
// Create an associative array with the values
$response = array(
    "cost" => $cost,
    "gst" => $gst,
  "in_ex_gst" => $in_ex_gst,
  	"gst_amt" => $gst_amt,
  "net_price" => $net_price
);

                                  // header('Content-Type: application/json');
// Convert the array to JSON and echo it
echo json_encode($response);
					}
				}
				
					}
							
						
?>
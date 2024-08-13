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

		
		if($conn->connect_error)
		{
			die("connection failed:" . $conn->connect_error);
		}
				
		else

		{

		$result=mysqli_query($conn,"select * from patients");

		$id=$_GET["id"];
		
		 $sql = "delete from  patients where id= $id ";
		 
		 if ($conn->query($sql) === TRUE)
		 {
			 
			 ?>
			  <script>
			window.location="view-patients.php";
				alert("deleted the selected record");
		</script>
			  
			  <?php
		 }
			 else
			 { ?>
			  <script>
			window.location="view-patients.php";
				alert("Failed to delete record try again!!! ");
		</script>
			  
			  <?php
			 }
		
		
		}
		
		
		
?>
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
$result=false;
 


$old_pwd=mysqli_real_escape_string($conn,$_POST["old_pwd"]);
$new_pwd=md5($_POST["new_pwd"]);
$con_pwd=md5($_POST["con_pwd"]);

if($conn->connect_error)
		{
			die("connection failed:" . $conn->connect_error);
		}

	$sql="select * from manager_login";
		$result=$conn->query($sql);
			 if($row = mysqli_fetch_assoc($result)) 
			 {
				 $pass=$row["password"];
				
				 
			 }
			 
			 if($pass==$old_pwd)
			 {
				 $sql = "update manager_login set password='$new_pwd' where id=1";
					if ($conn->query($sql) === TRUE) 
					{
						?>
							<script>
							window.location="index.php";
								alert("Successfully Updated password");
							</script>
			  <?php
				 
			 }
			 else
			 {
				  echo "Error: " . $sql . "<br>" . $conn->error;
			 }
			 }
			 else
			 {
				 ?>
				 
						<script>
							window.location="profile.php";
							alert("Old Password doesn't match");
							</script>
				 
				 <?php
				 
			 }
			 


?>
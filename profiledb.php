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




$name=$_POST['pname'];

   $email=$_POST['email'];
   $phone=$_POST['pphone']; 


$imagename=$_FILES["image"]["name"];

$dist="./dist/img/".$imagename;

$dist1="dist/img/".$imagename;

move_uploaded_file($_FILES["image"]["tmp_name"],$dist);

$imageFileType = pathinfo($dist1,PATHINFO_EXTENSION);

if($_FILES["image"]["error"])
{

 $sql = "update manager_login set name='$name',email='$email',phone='$phone' where id=1";
} 
else {
 $sql = "update manager_login set name='$name',email='$email',phone='$phone',image='$dist1' where id=1";
}

 
 //$sql = "update admin_login set name='$name',email='$email',phone='$phone' where id=1";

			if ($conn->query($sql) === TRUE) 
		  {
			  ?>
			  <script>
			window.location="profile.php";
				alert("Successfully Updated ");
		</script>
			  <?php
			} 
		  else 
		  {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }



?>
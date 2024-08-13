<?php
$host="localhost";
$username="root";
$pass="";
$db="drspine-crm-db";



// $host="localhost";
//  $username="drspine-crm-user";
//  $pass="hJBUK9scHGc92U4n7gbg";
//  $db="drspine-crm-db";

		$conn=new mysqli($host,$username,$pass,$db);
		
		if($conn->connect_error)
		{
			die("connection failed:" . $conn->connect_error);
		}
		?>
		
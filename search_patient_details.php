
<!DOCTYPE html>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 
if(!isset($_SESSION['email'])){
   header("Location:login.php");
   
}
else
{
$_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
include("config.php");
?>

<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
 <link rel="icon" type="image/x-icon" href="dist/img/fav.ico">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="hold-transition sidebar-mini">
<div class="wrapper">
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo.png" alt="JyothiWoodsLogo" height="60" width="80">
  </div>
  
  <?php include("menu.php");?>
  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="width:'fit-content';">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Information</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php
if (isset($_GET['search'])) {
  $search = $_GET['search'];
  $sql = "SELECT * FROM appointments WHERE patient_id = '$search' OR email = '$search' OR mobile = '$search'";
  

    $result = $conn->query($sql);
    
    
echo "<script>console.log('SQL Query: " . mysqli_real_escape_string($conn, $sql) . "');</script>";

//echo "<script>alert('SQL Query: " . mysqli_real_escape_string($conn, $sql) . "');</script>";
if ($result->num_rows == 1) {
  $patient = $result->fetch_assoc();
  echo '<script>window.location.href = "view_single_patient_details.php?patient_id=' . $patient['patient_id'] . '";</script>';
} else
if ($result->num_rows > 0) {
    $patients = array(); // Create an array to store unique patient IDs
    while ($row = $result->fetch_assoc()) {
        $patient_id = $row['patient_id'];
        // Check if the patient ID is not in the array, then add it
        if (!in_array($patient_id, $patients)) {
            $patients[] = $patient_id;
        }
    }

    if (!empty($patients)) {
        
echo '<div style="padding-left: 20px;">'; // Adjust the value (20px) as needed for your desired padding
        echo "Multiple patients found under Mobile number/ E-Mail ID:<br>";
        echo '<table border="1">';
        echo '<tr><th>S.No</th>
        <th>Patient Name</th>
        <th>Patient ID</th>
        <th>Age</th>
        <th>Gender</th>
        
        <th>Relationship With Patient</th>
        <th>Relative Name</th>
        <th>Action</th>
        </tr>';
        

        $count = 1;
        foreach ($patients as $patient_id) {
            // Retrieve the patient's name from the first appointment record (assuming it's the same for all appointments)
            $sql = "SELECT * FROM appointments WHERE patient_id = '$patient_id'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $patient_name = $row['name'];
                $patient_age = $row['age'];
                $patient_gender = $row['gender'];
                $relationship_with_patient=$row['relationship_with_patient'];
                $relative_name=$row['relative_name'];
                echo '<tr>';
                echo '<td>' . $count++ . '</td>';
                echo '<td>' . $patient_name . '</td>';
                echo '<td>' . $patient_id . '</td>';
                echo '<td>' . $patient_age . '</td>';
                echo '<td>' . $patient_gender . '</td>';
                echo '<td>' . $relationship_with_patient . '</td>';
                echo '<td>' . $relative_name . '</td>';
                echo '<td><a href="view_single_patient_details.php?patient_id=' . $patient_id . '">View Patient Details</a></td>';
                echo '</tr>';
            }
        }
        echo '</table></div>';
    } 
}
 else {
  // Handle case where no patient found
  echo "Patient not found.";
  exit();
}
  } 

?>

</div>

<!-- /.content-wrapper -->


<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<?php include("footer.php");?>
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="../../dist/js/demo.js"></script> -->
<!-- Page specific script -->


<?php
// Close the database connection
$conn->close();
?>
</body>
</html>

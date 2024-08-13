
<!DOCTYPE html>
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
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>View New Patients</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">New Patients</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">

             <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Patients</h3>
              </div>
               <div class="row col-12" style="margin-top:10px; margin-left: 15px;">
              <form class="form-inline" method="POST" action="">
      <label>Date:</label>
      <input type="date" class="form-control" placeholder="Start"  name="date1" value="<?php echo isset($_POST['date1']) ? $_POST['date1'] : '' ?>" />
      <label>To</label>
      <input type="date" class="form-control" placeholder="End"  name="date2" value="<?php echo isset($_POST['date2']) ? $_POST['date2'] : '' ?>"/>
      <button class="btn btn-primary" name="search" style="margin-left:4px;margin-right:4px;"><i class="fa fa-search"></i></button> <a href="#" type="button" class="btn btn-success"><i class = "fa fa-refresh"></i></a>
    </form>
  </div>
  

 

  <!-- Bulk Upload Starts -->
  <style>
    #excelForm {
      margin-left: 23px;
      margin-top: 30px;
      
      
    }
  </style>
  <br>
<!--   <form action="upload_excel.php" method="post" enctype="multipart/form-data" id="excelForm">
    <label for="excelFile">Bulk Upload:</label>
    <input type="file" name="excelFile" id="excelFile" accept=".xls, .xlsx">
    <input type="submit" class="btn btn-success btn-upload" value="Upload" name="import">
</form> -->




  
<!-- Bulk Upload Ends -->



<?php


// Assuming you have a database connection established already

// Fetch patient data from the database
$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);

?>

<div class="card-body">
<table id="example1" class="table table-bordered jsgrid-table" style="box-shadow: 1px 2px 4px 0px #8080804f;">
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Branch Name</th>
            <th>Patient Id</th>
            <th>Name</th>
            <th>Age</th>
            <th>Email</th>
            <th>Contact No</th>
            <!-- <th>Status</th>
            <th>Purpose</th>
            
            <th>Date of Birth</th> -->
            
            <th>Gender</th>
            <!-- <th>Occupation</th>
            <th>Address</th>
            <th>Doctor</th>
            <th>Issue</th> -->
            <th>Date</th>
            <!-- <th>Time From</th>
            <th>Time To</th>
            <th>Payment Status</th> -->
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row["id"] ?></td>
                <td><?php echo $row["branch_name"] ?></td>
                <td><?php echo $row["patient_id"] ?></td>
                <td><?php echo $row["name"] ?></td>
                <td><?php echo $row["age"] ?></td>
                <td><?php echo $row["email"] ?></td>
                <td><?php echo $row["mobile"] ?></td>
                <!-- <td><?php echo $row["status"] ?></td>
                <td><?php echo $row["purpose"] ?></td>
               
                <td><?php echo $row["date_of_birth"] ?></td> -->
                
              
                <td><?php echo $row["gender"] ?></td>
                <!-- <td><?php echo $row["occupation"] ?></td>
                <td><?php echo $row["address"] ?></td>
                <td><?php echo $row["doctor"] ?></td>
                <td><?php echo $row["issue"] ?></td> -->
                <td><?php echo $row["date"] ?></td>
                <!-- <td><?php echo $row["time_from"] ?></td>
                <td><?php echo $row["time_to"] ?></td>
                <td><?php echo $row["payment_status"] ?></td> -->
                <td>
                    <div class="btn-group">
                        <a class="btn btn-primary view-patient-details" href="#" data-id="<?php echo $row['id']; ?>" title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                        &nbsp;
                        <a class="btn btn-info" href="update-patients.php?id=<?php echo $row['id'] ?>" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                        &nbsp;
                        <!-- <a class="btn btn-danger" href="del_patients.php?id=<?php echo $row['id'] ?>" title="Delete">
                            <i class="fa fa-trash white trash"></i>
                        </a> -->
                        <form action="" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlentities($row['id']); ?>">
        <button type="submit" name="deleteBtn" class="btn btn-danger">
        <i class="fa fa-trash white trash"></i>
        </button>
    </form>
  <?php
if (isset($_POST['deleteBtn'])) {
    // Retrieve the product ID from the form submission
    $id = $_POST['id'];


    // Delete the product from the cart table
    $sql = "DELETE FROM `appointments` WHERE `id` = $id";
    if ($conn->query($sql) === TRUE) {
        $successMessage = "Patient deleted  successfully.";
        echo '<script>alert("' . $successMessage . '");</script>';
        echo '<script>window.location.href = window.location.href;</script>';
    } else {
        $errorMessage = "Error deleting Patient Details: " . $conn->error;
        echo '<script>alert("' . $errorMessage . '");</script>';
    }

    // Close the connection
    $conn->close();
}
?>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</div>


        
      </div>
      
    </section>
    

  </div>
  
 

  <?php

// Check if the updated patient ID is stored in the session
if (isset($_SESSION['updated_patient_id'])) {
    $updated_patient_id = $_SESSION['updated_patient_id'];

    // Fetch the updated patient details from the database using $updated_patient_id
    $select_sql = "SELECT * FROM patients WHERE id=?";
    $select_stmt = $conn->prepare($select_sql);
    $select_stmt->bind_param("i", $updated_patient_id);
    $select_stmt->execute();
    $result = $select_stmt->get_result();

    if ($result->num_rows === 1) {
        $updated_patient = $result->fetch_assoc();

        // Display the updated patient details here
        
        echo "<p>Name of the Patient: " . $updated_patient['pname'] . "</p>";
        echo "<p>Gender: " . $updated_patient['gender'] . "</p>";
        echo "<p>DOB: " . $updated_patient['dob'] . "</p>";
        echo "<p>Occupation: " . $updated_patient['occupation'] . "</p>";
        echo "<p>Age: " . $updated_patient['age'] . "</p>";
        echo "<p>Email: " . $updated_patient['email'] . "</p>";
        echo "<p>Date: " . $updated_patient['date'] . "</p>";
        echo "<p>Contact Number: " . $updated_patient['contact_mnumber'] . "</p>";
        echo "<p>Location: " . $updated_patient['location'] . "</p>";
        echo "<p>City: " . $updated_patient['city'] . "</p>";
        echo "<p>Treatment: " . $updated_patient['treatment'] . "</p>";
        echo "<p>No.of Session Plans: " . $updated_patient['session_plans'] . "</p>";

        // Clear the session variable after displaying the details
        unset($_SESSION['updated_patient_id']);
    }

    $select_stmt->close();
}
?>
<?php #include("upload_excel.php"); ?>
  <!-- /.content-wrapper -->
 <?php include("footer.php");?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

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
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
      
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>


  <!-- Popup Modal Starts -->

<div id="patientModal" class="modal fade">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Patient Details</h4>
        
      </div>
      <div class="modal-body text-center" id="patientDetails">
        <!-- Patient details will be displayed here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Popup Modal Starts -->

<script>
$(document).ready(function () {
  // Handle the click event for "View" icon
  $(".view-patient-details").click(function () {
    var patientId = $(this).data("id");

    // Fetch patient details using AJAX
    $.ajax({
      url: "view-patient.php", // Create a PHP file to fetch patient details
      method: "GET",
      data: { id: patientId },
      success: function (response) {
        // Update the modal content with patient details
        $("#patientDetails").html(response);
        // Show the modal
        $("#patientModal").modal("show");
      },
      error: function () {
        alert("Error fetching patient details.");
      },
    });
  });
});
</script>





</body>
</html>

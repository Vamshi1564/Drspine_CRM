  


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

if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];
   
    
  

    
    // Fetch patient details using $patient_id
    $sql = "SELECT * FROM appointments WHERE id = $patient_id"; 
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $patient = $result->fetch_assoc();
    } else {
        // Handle case where no patient found
        echo "Patient not found.";
        exit();
    }
} else {
    // Handle case where no patient ID is provided
    echo "Patient ID not provided.";
    exit();
}
?>


  <style>
    .card-body {
  background-color: #f7f7f7;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
  
  width:100%;
}

.card-body table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 15px;
}

.card-body td {
  padding: 5px;
  border: 1px solid #ddd;
}

.card-body p.heading {
  font-weight: bold;
  margin: 0;
}
.card-body p.data {
  margin-top: 18px;
}

.card-body a {
  text-decoration: none;
  color: #007bff;
}

.card-body a:hover {
  text-decoration: underline;
}

.card-body a:active {
  color: #0056b3;
}

.card-body a:focus {
  outline: none;
}
  </style>

  <!-- Main content -->
  <section class="content">
      <div class="container-fluid" style="margin-left: 50px;">
      <div class="row">
        <div class="col-md-3">
        <h4 style="margin-top: 12px; margin-left: 30px;">Patient Id:</h4>
        </div>
      <div class="col-md-3">
                <table class="table" style="height: 58px; margin-left:-170px;">
                    <tr>
                        <td class="text-center text-black" style="font-size: 18px; border:none; letter-spacing: 3px; font-weight:bold;text-transform:uppercase;"><?php echo $patient['patient_id']; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-3">
        <h4 style="margin-left: -120px; margin-top: 12px;">Patient Name:</h4>
        </div>
      <div class="col-md-3">
                <table class="table" style="height: 58px; margin-left:-230px;">
                    <tr >
                        <td class="text-center text-black" style="font-size: 18px;border:none; letter-spacing: 3px; font-weight:bold; text-transform:uppercase;"><?php echo $patient['name']; ?></td>
                    </tr>
                </table>
            </div>
            
      </div>
      </div>





<div class="card-body">
<table>
  
  <tr>
    <td><p class="heading">Name:</p></td>
    <td><p class="data"><?php echo $patient['name']; ?></p></td>
    <td><p class="heading">Patient ID:</p></td>
    <td><p class="data"><?php echo $patient['patient_id']; ?></p></td>
  </tr>
  <tr>
  <td><p class="heading">Date of Visit:</p></td>
   <td><p class="data"><?php echo date('d/m/Y', strtotime($patient['date'])); ?></p></td>
    <td><p class="heading">Appointment Time:</p></td>
    <td><p class="data"><?php echo $patient['time']; ?></p></td>
  </tr>
  <tr>
  <td> <p class="heading">Age:</p></td>
    <td> <p class="data"><?php echo $patient['age']; ?></p></td>
    <td><p class="heading">Occupation :</p></td>
    <td><p class="data"><?php echo $patient['occupation']; ?></p></td>
  </tr>
  <tr>
    <td><p class="heading">Mobile No:</p></td>
    <td><p class="data"><?php echo $patient['mobile']; ?></p></td>
    <td><p class="heading">Doctor:</p></td>
    <td><p class="data"><?php echo $patient['doctor']; ?></p></td>
  </tr>
  <tr>
  <td> <p class="heading">Email:</p></td>
    <td> <p class="data"><?php echo $patient['email']; ?></p></td>
    <td><p class="heading">No of Sessions :</p></td>
    <td><p class="data"><?php echo $patient['no_of_session']; ?></p></td>
  </tr>
  <tr>
    <td><p class="heading">Mobile No:</p></td>
    <td><p class="data"><?php echo $patient['mobile']; ?></p></td>
    <td><p class="heading">Doctor:</p></td>
    <td><p class="data"><?php echo $patient['doctor']; ?></p></td>
  </tr>
  <tr>
    <td><p class="heading">City:</p></td>
    <td><p class="data"><?php echo $patient['city']; ?></p></td>
    <td><p class="heading">Issue:</p></td>
    <td><p class="data"><?php echo $patient['issue']; ?></p></td>
  </tr>
  <tr>
    <td><p class="heading">Payment Status:</p></td>
    <td><p class="data"><?php echo $patient['payment_status']; ?></p></td>
    <td><p class="heading">Gender:</p></td>
    <td><p class="data"><?php echo $patient['gender']; ?></p></td>
  </tr>
 </table>

 <div style="margin-top: 20px; text-align: center;">
    <a href="calender.php">&laquo; Return Back to Patients List</a>
</div>

</div>


<h3 class="mt-3">Session Details</h3>
<div class="container-fluid pt-3">
                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <a class="btn btn-flat btn-primary" onclick="openPopup()"><span
                                                class="fas fa-plus"></span> Add Sessions</a>
                                    </div>                                </div>
                                <div class="row col-12"
                                    style="margin-top:10px; margin-left: 15px;">
                                    <!-- <form class="form-inline" method="POST" action="">
                                        
                                        <button class="btn btn-primary" name="search"
                                            style="margin-left:4px;margin-right:4px;"><i class="fa fa-search"></i></button>
                                        <a href="#" type="button" class="btn btn-success"><i class="fa fa-refresh"></i></a>
                                    </form> -->

                                </div>

                                <?php

                                // Assuming you have a database connection established already

                                // Fetch patient data from the database
                               
$sql = "SELECT * FROM sessions";
$result = $conn->query($sql);

                                ?>
                                <style>
                                    /* If you want to keep the box-shadow as well */
                                    #example1 {
                                        width: 100% !important;
                                        box-shadow: 1px 2px 4px 0px #8080804f;
                                    }

                                </style>

                                <div class="card-body">
                                    <table id="example1"
                                        class="table table-bordered jsgrid-table"
                                        style=" box-shadow: 1px 2px 4px 0px #8080804f;">
                                         <thead>
                                         <tr>
                                             <th>SL.NO</th>
                                             <th>Date & Time</th>
                                             <th>Treatment</th>
                                             <th>Doctor</th>
                                            <th>Prescription</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                            </tr>
                                            </thead>
                                        <tbody>
            <?php
            $counter = 1;
            while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $counter ?></td>
                    <td><?php echo $row["date_time"] ?></td>
                    <td><?php echo $row["treatment"] ?></td>
                    <td><?php echo $row["doctor"] ?></td>
                    <td><?php echo $row["priscription"] ?></td>
                    <td><?php echo $row["status"] ?></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-info"
                                href="sessions_update.php?id=<?php echo $row['id']; ?>"
                                title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            &nbsp;
                            <a class="btn btn-danger"
                                href="del_sessions.php?id=<?php echo $row['id'] ?>"
                                title="Delete">
                                <i class="fa fa-trash white trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php
                $counter++;
            }
            ?>
        </tbody>
    </table>
                                    </table>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>
<style>
    .folder-button {
      display: flex;
      flex-direction: column;
      align-items: center;
      background-color: #f5f5f5;
      padding: 10px;
      border-radius: 5px;
      cursor: pointer;
      outline: none;
      transition: background-color 0.2s, box-shadow 0.2s;
      margin-top: 20px;
      margin-bottom: 20px;
      height: 150px;
      width: 250px;
    }

    .folder-button:hover {
      background-color: LightGray;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .folder-icon i {
      font-size: 80px;
      color: #F8D775;
      margin-bottom: 10px;
    }

    .folder-name {
      font-size: 18px;
      font-weight: bold;
      text-align: center;
    }

    /* Container for the upload form */


/* Styling for the upload form */
.upload-form {
  
  padding: 20px;

  text-align: center;
}

/* Styling for the file input label */
.file-label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}

/* Styling for the file input */
.file-input {
  display: block;
  margin: 0 auto 15px auto;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  width: 100%;
}

/* Styling for the submit button */
.submit-button {
  display: block;
  margin: 0 auto;
  padding: 10px 20px;
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.submit-button:hover {
  background-color: #0056b3;
}
    
  </style>
<section>

<div class="container-fluid" style="margin-left: 200px;">
    <div class="row">
      <div class="col-md-3"> 
    <form action="upload.php?patient_id=<?php echo $patient['patient_id']; ?>" method="post" enctype="multipart/form-data" class="upload-form">
      <label for="fileToUpload" class="file-label"></label>
      <input type="file" name="fileToUpload" id="fileToUpload" class="file-input">
      <input type="submit" value="Upload File" name="submit" class="submit-button">
    </form>
  </div>
      </a>
      <div class="col-md-3">
      <a class="folder-button" id="openFolderButton" href="files.php?patient_id=<?php echo $patient['patient_id']; ?>">
          <div class="folder-icon">
            <i class="fas fa-folder"></i>
          </div>
          <div class="folder-name">
            DOCUMENTS & REPORTS
          </div>
        </a>
      </div>
      </div>
    </div>
   
  </div>
</div>
</div>
</section>
</div>






      <style>
            .popup {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.5);
                z-index: 9999; 
            }

            .popup-content {
                background-color: white;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                padding: 20px;
                box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            }

            .close {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 20px;
                cursor: pointer;
            }

            .email_column {
                max-width: 100px;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .issue {
                max-width: 50px;
                overflow: hidden;
                text-overflow: ellipsis;
            }

        </style>

<div class="popup" id="popup">
            <div class="popup-content" >
            <span class="close" onclick="closePopup()" style="position: absolute; top: 10px; right: 10px; font-size: 20px; cursor: pointer;">&times;</span>

                <form action="sessionsdb.php" method="POST" enctype="multipart/form-data" style="width:600px;">

                    <h3>Book Appointment</h3>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="date&time">Date & Time</label>
                            <input type="datetime-local" class="form-control" name="date_time" id="date_time"required>

                        </div>


                        <div class="form-group col-md-6">
                            <label for="treatment">Treatment</label>
                            <input type="text" class="form-control" id="treatment" name="treatment" required>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="doctor">Doctor</label>
                            <input type="text" class="form-control" id="doctor" name="doctor" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="priscription">Prescription</label>
                            <input type="text" class="form-control" id="priscription" name="priscription" required>
                        </div>
                    </div>

                    <div class="row">
    <div class="form-group col-md-12">
        <label for="status">Status</label>
        <select class="form-control" id="status" name="status" required>
            <option value="attended">Attended</option>
            <option value="cancelled">Cancelled</option>
            <option value="postponed">Postponed</option>
        </select>
    </div>
</div>
                    <center>
                        <button type="submit" class="btn btn-primary mx-1" name="save">Submit</button>
                    </center>

                </form>
            </div>
        </div>
        <script>
            function openPopup() {
                var popup = document.getElementById("popup");
                popup.style.display = "block";
            }

            function closePopup() {
                var popup = document.getElementById("popup");
                popup.style.display = "none";
            }
        </script>



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

<?php
// Close the database connection
$conn->close();
?>
</body>
</html>

  <!DOCTYPE html>
  <?php

  session_start();
  if (!isset($_SESSION['email'])) {
    header("Location:login.php");
  } else {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
  }
  include("config.php");
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

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

      <?php include("menu.php"); ?>
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

        if (isset($_GET['patient_id'])) {
          $patient_id = $_GET['patient_id'];
          $branch_name = $_GET['branch_name'];
          // Fetch patient details using $patient_id
          $sql = "SELECT * FROM drspine_appointment WHERE patient_id = '$patient_id' and branch_name = '$branch_name'";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            $patient = $result->fetch_assoc();
            // if(isset($_GET['branch_name']){
            //  $branch_name = $_GET['branch_name'];
            //}
            // else
            //{
            // $branch_name = $patient['branch_name'];
            //}

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

            width: 100%;
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
                  <tr>
                    
                   <td class="text-center text-black" style="font-size: 18px;border:none; letter-spacing: 3px; font-weight:bold; text-transform:uppercase;">
    <?php 
    echo $patient['patient_first_name'] . " " . $patient['patient_middle_name'] . " " . $patient['patient_last_name']; 
    ?>
   </td>
                  </tr>
                </table>
              </div>

            </div>
          </div>





          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <div>
                  <table>
                    <tr>
                      <!-- <td><p><span class="text-bold">Name: </span><span class="data"><?php echo $patient['patient_first_name'] . " " . $patient['patient_last_name']; ?></span></p></td>
                    
                        <td><p class="text-bold">Patient ID: <span class="data"><?php echo $patient['patient_id']; ?></span></p></td> -->
                      <td>
                        <p>
                          <span class="text-bold">DOB: </span>
                          &nbsp;
                          <span class="data">
                            <?php echo date('d/m/Y', strtotime($patient['date_of_birth'])); ?>
                          </span>
                        </p>
                      </td>

                      <td>
                        <p><span class="text-bold">Gender:</span> &nbsp;<span class="data"><?php echo $patient['gender']; ?></span></p>
                      </td>
                    </tr>

                    <tr>
                      <td>
                        <p><span class="text-bold">Mobile: </span> &nbsp;<span class="data"><?php echo $patient['contact_no']; ?></span></p>
                      </td>

                      <td>
                        <p><span class="text-bold">Address: </span> &nbsp; <span class="data"><?php echo $patient['patient_address']; ?></span></p>
                      </td>

                      <!-- <td> <p ><span class="heading">Occupation: </span><span class="data"><?php echo $patient['occupation']; ?></span></p></td> -->
                    </tr>
                    <tr>
                      <td>
                        <p><span class="text-bold">Email: </span> &nbsp;<span class="data"><?php echo $patient['email_address']; ?></span></p>
                      </td>
                      <!--  <td><p class="heading">Date of Visit: <span><?php echo date('d/m/Y', strtotime($patient['date'])); ?></span></p></td>
    <td><p class="heading">Appointment Time:<span class="data"><?php echo $patient['time_from'] . '-' . $patient['time_to']; ?></span></p></td>-->
                      <!-- <td><p><span class="text-bold" >appointment :</span><span class="data"><?php echo $patient['appointment_date_time']; ?></span></p></td> 
  <td><p><span class="text-bold" >Doctor:</span><span class="data"><?php echo $patient['doctor_name']; ?></span></p></td>
 <td><p><span class="text-bold" >Issue:</span><span class="data"><?php echo $patient['reason_for_appointment']; ?></span></p></td>  -->
                    </tr>

                  </table>

                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" style="float:right;">
                    Edit Details
                  </button>
                </div>
              </div>
              <div class="col-md-3">
                <div style="box-shadow:1px 1px 6px 0 rgba(0, 0, 0, 0.16)">

                  <?php
                   if(isset($_SESSION['branch_name_s']))
                   {
                     $branch_name = $_SESSION['branch_name_s'];
                   }else{
                     $branch_name = $_GET['branch_name'];
                   }
               
                  if (($_SESSION['role'] == 'admin') || $_SESSION['role'] ==  'fd' && $_SESSION['role'] != 'cc') {
                   
                     if ( $branch_name === $_SESSION['branch_name'] || $_SESSION['role'] === 'admin') {


                  ?>
                      <ul style="list-style: none;">
                        <li style="padding:8px;"> <a href="manage_invoice.php?patient_id=<?php echo $patient['patient_id'] ?>&mobile=<?php echo $patient['contact_no'] ?>&email=<?php echo $patient['email_address'] ?>&branch_name=<?php echo $branch_name; ?>" style="color:black;">Invoice</a></li>
                        <li style="padding:8px;"> <a href="manage_receipts.php?patient_id=<?php echo $patient_id; ?>&branch_name=<?php echo $branch_name; ?>" style="color:black;">Receipts</a></li>

                      </ul>
                  <?php
                    }
                  } ?>
                </div>
              </div>
            </div>


            <!-- Edit patient modal Starts -->
            <div class="modal mt-5" id="editModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <!-- Modal Header -->
                  <div class="modal-header">
                    <h4 class="modal-title">Edit Patient Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>

                  <!-- Modal Body -->
                  <div class="modal-body">
                    <form action="update_single_patient_details.php?patient_id=<?php echo $patient_id; ?>&branch_name=<?php echo $_GET['branch_name']?>" method="post">

                      <!-- Input fields for editing patient details -->
                      <label>First Name:</label>
                    <input type="text" name="patient_first_name" value="<?php echo $patient['patient_first_name']; ?>" class="form-control">
                    <label>Middle Name:</label>
                    <input type="text" name="patient_middle_name" value="<?php echo $patient['patient_middle_name']; ?>" class="form-control">
                    <label>Last Name:</label>
                    <input type="text" name="patient_last_name" value="<?php echo $patient['patient_last_name']; ?>" class="form-control">
                      
                      <label>Date of Birth:</label>
                      <input type="date" name="date_of_birth" value="<?php echo date('Y-m-d', strtotime($patient['date_of_birth'])); ?>" class="form-control">
                      <label>Gender:</label>
                      <input type="text" name="gender" value="<?php echo $patient['gender']; ?>" class="form-control">
                      <label>Mobile:</label>
                      <input type="text" name="contact_no" value="<?php echo $patient['contact_no']; ?>" class="form-control">
                      <label>Address:</label>
                      <input type="text" name="patient_address" value="<?php echo $patient['patient_address']; ?>" class="form-control">
                      <label>Email:</label>
                      <input type="email" name="email_address" value="<?php echo $patient['email_address']; ?>" class="form-control">

                      <!-- Modal Footer -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" value="Update Details">
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            <!-- Edit patient modal ends -->


            <!-- 
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
    <td><p class="data"><?php echo $patient['time_from'] . '-' . $patient['time_to']; ?></p></td>
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
    <td><p class="data"><?php echo $patient['no_of_sessions']; ?></p></td>
  </tr>
  <tr>
    <td><p class="heading">Mobile No:</p></td>
    <td><p class="data"><?php echo $patient['mobile']; ?></p></td>
    <td><p class="heading">Doctor:</p></td>
    <td><p class="data"><?php echo $patient['doctor']; ?></p></td>
  </tr>
  <tr>
    <td><p class="heading">Address:</p></td>
    <td><p class="data"><?php echo $patient['address']; ?></p></td>
    <td><p class="heading">Issue:</p></td>
    <td><p class="data"><?php echo $patient['issue']; ?></p></td>
  </tr>
  <tr>
    <td><p class="heading">Payment Status:</p></td>
    <td><p class="data"><?php echo $patient['payment_status']; ?></p></td>
    <td><p class="heading">Gender:</p></td>
    <td><p class="data"><?php echo $patient['gender']; ?></p></td>
  </tr>
 </table> -->

            <!-- <div style="margin-top: 20px; text-align: center;">
    <a href="calender.php">&laquo; Return Back to Patients List</a>
</div> -->

          </div>


          <h3 class="mt-3">Session Details</h3>
          <div class="container-fluid pt-3">
            <div class="row">
              <div class="col-12">

                <div class="card">
                  <div class="card-header">
                    <div class="card-tools">
                      <!-- <a style="margin-right:10px;" class="btn btn-flat btn-primary" href="add_appointment_old_patient.php">
                                        <span class="fas fa-plus"></span> Add Appointment</a> <br><br>
                                    

                                     -->

                    </div>
                    <div class="row col-12" style="margin-top:10px; margin-left: 15px;">
                      <!-- <form class="form-inline" method="POST" action="">
                                        
                                        <button class="btn btn-primary" name="search"
                                            style="margin-left:4px;margin-right:4px;"><i class="fa fa-search"></i></button>
                                        <a href="#" type="button" class="btn btn-success"><i class="fa fa-refresh"></i></a>
                                    </form> -->

                    </div>

                    <?php

                    // Assuming you have a database connection established already

                    // Fetch patient data from the database
                    $sql = "SELECT * FROM drspine_appointment WHERE patient_id = '$patient_id'";

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
                      <center>
                        <h3>Appointments Table</h3>
                      </center>

                      <table id="example1" class="table table-bordered jsgrid-table" style=" box-shadow: 1px 2px 4px 0px #8080804f;">
                        <thead>
                          <tr>
                            <!-- <th>S.No</th> -->
                            <th>OP.No </th>
                            <th>Date & Time</th>
                            <th>Duration</th>
                            <!-- <th>Time To</th> -->

                            <th>Doctor</th>

                            <!-- <th>Issue</th> -->
                            <!-- <th>No.of Sessions</th> -->
                            <th>status</th>
                            <th>No.of Sessions</th>
                            <!-- <th>purpose</th> -->
                            <th>branch_name</th>

                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $counter = 1;
                          while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                              <input type="hidden" class="form-control" id="appointment_number" name="appointment_number" value=" <?php echo $row["appointment_number"] ?>">
                              <td><?php echo $counter ?></td>
                              <!-- <td>
                                                    
                                                    <?php echo $row["appointment_number"] ?></td> -->
                              <td>
                                <?php
                                $appointment_datetime = $row["appointment_date_time"];
                                if ($appointment_datetime) {
                                  $formatted_datetime = date('d/m/y h:i A', strtotime($appointment_datetime));
                                  echo $formatted_datetime;
                                } else {
                                  echo 'No Date Provided';
                                }
                                ?>
                              </td>

                              <td><?php echo $row["duration_minutes"] ?></td>
                              <!-- <td><?php echo $row["time_to"] ?></td> -->



                              <td><?php echo $row["doctor_name"] ?></td>

                            <!--   <td><?php echo $row["reason_for_appointment"] ?></td> -->

                              <!-- <td> -->
                              <?php
                              // $sql = "SELECT COUNT(DISTINCT appointment_number) AS no_of_sessions FROM sessions WHERE patient_id = '$patient_id'";
                              // $result = $conn->query($sql);

                              // if (!$result) {
                              //     // Query execution error
                              //     echo '<script>alert("Error: ' . $conn->error . '");</script>';
                              // } else {
                              //     $no_of_sessions = 0;
                              //     if ($result->num_rows > 0) {
                              //         $no_of_sessions = $result->num_rows;
                              //     }

                              //     // Now you have $no_of_sessions containing the count directly
                              //     echo $no_of_sessions;
                              // }
                              ?>
                              <!-- </td> -->



                              <td><?php echo $row["today_status"] ?></td>
                              <!-- <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="status-form">
        <input type="hidden" value="<?php echo $row['id']; ?>" name="status_row_id"/>
        <select name="status" class="form-control status-select" style="width:100% !important;">
        <option value="<?php echo $row["status"] ?>"><?php echo $row["status"] ?></option>
            <option value="visited">Visited</option>
            <option value="cancelled">Cancelled</option>
            <option value="pending">Pending</option>
        </select>
        <br/>
        <button type="submit" name="status_submit" class="btn-success"><i class="fa fa-floppy-o" style="color:white;"></i></button>
    </form> -->
                              </td>
                              <td>
                                <?php
                                $no_of_sessions_sql = "SELECT COUNT(`appointment_number`) as no_of_sessions FROM `sessions` WHERE `appointment_number` = '{$row['appointment_number']}' AND `patient_id` = {$row['patient_id']}";
                                $no_of_sessions_result = mysqli_query($conn, $no_of_sessions_sql);

                                if ($no_of_sessions_result) {
                                  $no_of_sessions_row = mysqli_fetch_assoc($no_of_sessions_result);
                                  $no_of_sessions = $no_of_sessions_row['no_of_sessions'];
                                  echo $no_of_sessions_row['no_of_sessions'];
                                }

                                ?>
                              </td>
                              <!-- <td>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="purpose-form">
        <input type="hidden" value="<?php echo $row['id']; ?>" name="purpose_row_id"/>
        <select name="purpose" class="form-control purpose-select" style="width:100% !important;">
        <option value="<?php echo $row["purpose"] ?>"><?php echo $row["purpose"] ?></option>
        <option value="appointment">Appointment</option>
        <option value="session">Session</option>
        </select>
        <br/>
         <button type="submit" name="purpose_submit" class="btn-success"><i class="fa fa-floppy-o" style="color:white;"></i></button>
    </form>
</td> -->

                              <td><?php echo $row["branch_name"] ?></td>
                              <!-- <td> -->
                              <!-- <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="branch_name-form">
        <input type="hidden" value="<?php echo $row['id']; ?>" name="branch_name_row_id"/>
        <select name="branch_name" class="form-control branch_name-select" style="width:100% !important;">
            <option value="<?php echo $row["branch_name"] ?>"><?php echo $row["branch_name"] ?></option>
            <option value="BEL Road">BEL Road</option>
                                                        <option value="ind">IND</option>
                                                        <option value="whitefield">Whitefield</option>
        </select>
        <br/>
        <button type="submit" name="branch_name_submit" class="btn-success"><i class="fa fa-floppy-o" style="color:white;"></i></button>
    </form> -->
                              <!-- </td> -->




                              <td>
                                <!-- <div class="btn-group">
                                                            <a class="btn btn-info"
                                                                href="update_appointment.php?id=<?php echo $row['id']; ?>"
                                                                title="Edit">
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            &nbsp;
                                                            <a class="btn btn-danger"
                                                                href="del_appointment.php?id=<?php echo $row['id'] ?>"
                                                                title="Delete">
                                                                <i class="fa fa-trash white trash"></i>
                                                            </a> -->

                                <a class="btn btn-flat" onclick="openPopup('<?php echo $row['id']; ?>', '<?php echo $row['appointment_number']; ?>', '<?php echo $row['branch_name']; ?>', '<?php echo $row['doctor_name']; ?>')">
                                  <span class="fas fa-plus"></span> Add Sessions
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
                  </div>

                  <?php

                  // Fetch unique appointment numbers for the patient
                  $sql = "SELECT DISTINCT appointment_number FROM sessions WHERE patient_id = '$patient_id'";
                  $appointmentNumbersResult = $conn->query($sql);
                  ?>

           <div class="card-body">
                    <center>
                      <h3>Sessions Table</h3>
                    </center>
                    <form action="" method="POST" enctype="multipart/form-data">
                      <div class="row">
                        <div class="form-group col-md-4">
                          <label for="patient_id">Patient Id</label>
                          <input type="text" class="form-control" id="patient_id" name="patient_id" value="<?php echo isset($patient_id) ? $patient_id : ''; ?>">
                        </div>
                        <div class="form-group col-md-4">
    <label for="appointment_number">Appointment Number</label>
    <select class="form-control" id="appointment_number" name="appointment_number">
        <option value="">Select Appointment Number</option>
        <?php
        while ($row = $appointmentNumbersResult->fetch_assoc()) {
            $appointmentNumber = $row['appointment_number'];
            $selected = isset($_POST['appointment_number']) && $_POST['appointment_number'] == $appointmentNumber ? 'selected' : '';
            echo '<option value="' . $appointmentNumber . '" ' . $selected . '>' . $appointmentNumber . '</option>';
        }
        ?>
    </select>
</div>


                        <div class="form-group col-md-4 mt-4">
                          <button type="submit" name="search" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                  </div>

                  <?php
                  // Check if the user has selected an appointment number
                  if (isset($_POST['appointment_number'])) {
                    $selectedAppointmentNumber = $_POST['appointment_number'];


                    $sql = "SELECT * FROM sessions WHERE patient_id = '$patient_id' AND appointment_number = '$selectedAppointmentNumber'";
                    $result = $conn->query($sql);
                  ?>
                    <table id="example1" class="table table-bordered jsgrid-table" style="box-shadow: 1px 2px 4px 0px #8080804f;">
                      <thead>
                        <tr>
                          <th>Session</th>
                          <th>Date & Time</th>
                          <th>Treatment</th>
                          <th>Doctor</th>
                          <th>Session no</th>
                          <th>Status</th>
                          <!-- <th>branch_name</th> -->
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $counter = 1;
                        while ($row = $result->fetch_assoc()) { ?>
                          <tr>
                            <td><?php echo $counter ?></td>
                            <td>
    <?php
    $date_time = $row["date_time"];
    $time_from = $row["time_from"];
    $time_to = $row["time_to"];

    if ($date_time) {
        $formatted_date = date('d/m/y', strtotime($date_time));
        echo $formatted_date;

        // Display time range if available
        if ($time_from && $time_to) {
            $formatted_time_range = date(' h:i A', strtotime($time_from)) . ' - ' . date('h:i A', strtotime($time_to));
            echo $formatted_time_range;
        }
    } else {
        echo 'No Date Provided';
    }
    ?>
</td>


                            <td><?php echo $row["treatment"] ?></td>
                            <td><?php echo $row["doctor"] ?></td>
                            <td><?php echo $row["session_no"] ?></td>
                            <td><?php echo $row["status"] ?></td>
                            <!-- <td><?php echo $row["branch_name"] ?></td> -->
                            <td>
                              <div class="btn-group">
                                <a class="btn btn-info" href="sessions_update.php?id=<?php echo $row['id']; ?>" title="Edit">
                                  <i class="fa fa-pencil"></i>
                                </a>
                                &nbsp;
                                <a class="btn btn-danger" href="del_sessions.php?id=<?php echo $row['id'] ?>" title="Delete">
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
                  <?php
                  }
                  ?>
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
              <form action="upload.php?patient_id=<?php echo $patient['patient_id']; ?>&branch_name=<?php echo $patient['branch_name']; ?>" method="post" enctype="multipart/form-data" class="upload-form">
                <label for="fileToUpload" class="file-label"></label>
                <input type="file" name="fileToUpload" id="fileToUpload" class="file-input">
                <textarea name="comments" placeholder="Add comments..." class="comments-textarea" style="width: 250px;"></textarea>
                <input type="submit" value="Upload File" name="submit" class="submit-button">
              </form>
            </div>
           <!-- </a>-->
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
      <div class="popup-content">
        <span class="close" onclick="closePopup()" style="position: absolute; top: 10px; right: 10px; font-size: 20px; cursor: pointer;">&times;</span>

        <form action="sessionsdb.php" method="POST" enctype="multipart/form-data" style="width:600px;">

          <h3>Book Session</h3>
          <div class="row">

            <input type="hidden" class="form-control" id="popup_id" name="popup_id">
            <input type="hidden" class="form-control" id="popup_appointment_number" name="popup_appointment_number">
            <input type="hidden" class="form-control" id="popup_branch_name" name="popup_branch_name">

            <input type="hidden" class="form-control" id="patient_id" name="patient_id" value="<?php echo $patient_id; ?>">
            <div class="form-group col-md-6">
              <label for="date">Date</label>
              <input type="date" class="form-control" name="date_time" id="date_time" required>

            </div>


            <div class="form-group col-md-6">
              <label for="treatment">Treatment</label>
              <input type="text" class="form-control" id="treatment" name="treatment" required>

            </div>
          </div>
          <div class="row">
                        <div class="form-group col-md-6">
                            <label for="time_from">From</label>
                            <input type="time" class="form-control" id="popup_time_from" name="popup_time_from" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="time_to">To</label>
                            <input type="time" class="form-control" id="popup_time_to" name="popup_time_to" required>
                        </div>
                    </div>

          <div class="row">
            <div class="form-group col-md-6">
              <label for="doctor">Doctor</label>
              <input type="text" class="form-control" id="popup_doctor_name" name="popup_doctor_name" required>
            </div>
            <div class="form-group col-md-6">
              <label for="session_no">Session No</label>
              <input type="text" name="session_no" id="session_no" class="form-control" placeholder="Enter Session No">
            </div>
          </div>

          <div class="row">
            <div class="form-group col-md-12">
              <label for="status">Status</label>
              <select class="form-control" id="status" name="status" required>
                <option value="Scheduled">Scheduled</option>
                <option value="Attended">Attended</option>
                <option value="Postponed">Postponed</option>
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
      function openPopup(id, appointmentNumber, branchName, doctorName) {
        // Set the values in the input fields
        document.getElementById("popup_id").value = id;
        document.getElementById("popup_appointment_number").value = appointmentNumber;
        document.getElementById("popup_branch_name").value = branchName;
        document.getElementById("popup_doctor_name").value = doctorName;

        // Show the popup modal
        document.getElementById("popup").style.display = "block";
      }

      function closePopup() {
        // Hide the popup modal
        document.getElementById("popup").style.display = "none";
      }
    </script>



    <!-- /.content-wrapper -->
    <?php include("footer.php"); ?>

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
      $(function() {
        $("#example1").DataTable({
          "responsive": false,
          "lengthChange": false,
          "autoWidth": false,

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
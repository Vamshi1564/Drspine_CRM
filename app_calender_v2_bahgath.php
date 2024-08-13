<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['email'])) {
  header("Location:login.php");
} else {
  $_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
include("config.php");


// Fetch appointments from the database
// if(isset($_SESSION['email']))
// {
$sql = "SELECT * FROM appointments";
// }
// elseif(isset($_SESSION['branch_admin_email']))

// {
// $branchName=$_SESSION['branch_name'];
// $branch_admin_name = $_SESSION['branch_admin_name'];
// $sql = "SELECT * FROM appointments where branch_admin = '$branch_admin_name' and branch = '$branchName'";
// }

$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $events[] = array(
      'title' => 'Appointment: ' . $row['name'],
      'start' => $row['date'] . "T" . $row['time_from'],
      'id' => $row['id'],
      'type' => 'appointment' // Add a type to distinguish between appointments and sessions
    );
  }
}

// Fetch sessions from the database
$sql = "SELECT * FROM sessions"; // Modify this query to match your database structure
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $events[] = array(
      'title' => 'Session: ' . $row['treatment'],
      'start' => $row['date_time'], // Assuming 'date_time' contains the session datetime
      // 'id' => $row['session_id'], // Modify to the correct column name
      'type' => 'session',
      'description' => 'Doctor: ' . $row['doctor'] . '<br>Prscription: ' . $row['priscription'] . '<br>Status: ' . $row['status']
    );
  }
}

// Encode events as JSON
$events_json = json_encode($events);
?>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>
  <link rel="icon" type="image/x-icon" href="dist/img/fav.ico">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- JQVMap -->
  <!--  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css"> -->
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <link rel="stylesheet" href="css/calendar.css">

  <style>
    /* .container {
            height: 100%;
            margin-top: 10px;
            margin-right: 70px;
        }

        .card-body {
            padding: 0;
            justify-content: center;
        }*/

    #calendar {
      max-width: 100%;
      margin: 0 auto;
    }

    /* Styles for the popup */
    .popup {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 9999;
      /* Make sure the popup appears on top */
    }

    .popup .popup-content {
      background-color: #fff;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
      width: 80%;
      /* Adjust this value as needed */
      max-width: 400px;
    }

    .popup .close {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 20px;
      cursor: pointer;
    }
  </style>
  
  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <script src='https://code.jquery.com/jquery-3.6.0.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js'></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="dist/img/logo.png" alt="" height="60" width="80">
    </div>

    <?php include("menu.php"); ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <!-- <li class="breadcrumb-item active">Profile </li> -->
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Appointments</h3>
                  <div style="float:right">
                    <select class="form-control" name="branch" id="branch">
                      <option value="whitefield">WhiteField</option>
                      <option value="BEL Road">BEL Road</option>
                      <option value="Indira Nagar">Indira Nagar</option>
                    </select>
                  </div>
                </div>
                <!-- /.card-header -->


                <div>
                  <label for="slotDurationSelect">Select Slot Duration: </label>
                  <select id="slotDurationSelect">
                    <option value="00:10:00">10 minutes</option>
                    <option value="00:15:00">15 minutes</option>
                    <option value="00:30:00">30 minutes</option>
                  </select>
                </div>
                <!-- form start -->
                <div class="card-body">
                  <div id="calendar"></div>
                </div>
              </div>
              <!-- /.card -->

            </div>



          </div>
          <!-- /.row -->

        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <?php include("footer.php"); ?>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->


  <!-- Event Details Popup -->
  <div id="eventDetailsPopup" class="popup">
    <div class="popup-content">
      <span class="close" onclick="closeEventDetailsPopup()" style="position: absolute; top: 10px; right: 10px; font-size: 20px; cursor: pointer;color: white; background-color: red; padding: 10px;">&times;</span>

      <div id="eventDetailsContent"></div>
    </div>
  </div>

  <script>
    function openAppointmentDetailsPopup(appointmentId) {
      $.ajax({
        url: 'get_appointment_details.php',
        type: 'GET',
        data: {
          Id: appointmentId
        },
        success: function(data) {
          $('#eventDetailsContent').html(data);
          $('#eventDetailsPopup').show();
        }
      });
    }
    
    function closeEventDetailsPopup() {
      $('#eventDetailsPopup').hide();
      $('#eventDetailsContent').empty(); // Clear the content when closing
    }

  </script>

  <script>
    $(document).ready(function() {
      var calendar = $('#calendar').fullCalendar({
        header: {
          left: 'prev,today',
          center: 'title',
          right: 'week,month,next'
        },
        defaultView: 'agendaDay',
        slotDuration: '00:10:00', // Set your default slot duration here
        minTime: '08:00:00',
        maxTime: '18:00:00',
        // Add your events data here
        events: [
          // Your events data goes here
        ],
      });

      // Function to open the appointment form popup
      function openAppointmentFormPopup(date, jsEvent, view) {
        // You can display your appointment form here as a popup
        
        $('#appointmentFormModal').modal('show');
      }

      // Bind the click event handler to the calendar
      $('#calendar').on('click', function(date, jsEvent, view) {
        openAppointmentFormPopup(date, jsEvent, view);
      });
    });
  </script>

  <!--  Modal for the Appointment Form -->
  <div class="modal fade" id="appointmentFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="width:1000px;height:1000px">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        
        <!-- Your appointment form HTML goes here -->
        <!-- Replace this with your actual form HTML -->
        <div class="modal-body" style="width:1000px;height:1000px">
          <!-- Your form content goes here -->
          <h3>Appointment Form</h3>
          <div id="appointment-form" style="left: 0px;"><div class="appointment-form-wrapper" style="width: 1000px;"><form class="form-horizontal"><div class="appointment-form-header"><div class="appointment-form-header-left"><div class="active"><span>Appointment</span></div><div class=""><span>Event</span></div></div><div class="appointment-form-header-right" style="display: flex;"><div id="appointment-date-picker" class="selected-date-time-wrapper"><span class="selected-date-time">Wednesday 4th Oct, 2023 at 08:55 AM</span></div><div><select class="form-control form-control-sm selected-duration"><option value="5" selected="">05 Minutes</option><option value="10">10 Minutes</option><option value="15">15 Minutes</option><option value="20">20 Minutes</option><option value="30">30 Minutes</option><option value="45">45 Minutes</option><option value="60">1 Hour</option><option value="90">1 Hours 30 Minutes</option><option value="120">2 Hours</option><option value="150">2 Hours 30 Minutes</option><option value="180">3 Hours</option></select></div></div></div>
          <div class="appointment-form-content" style="width: 1000px;"><div class="appointment-form-content-left flex-sixty"><div class="form-group"><label class="col-form-label"><span>Doctor</span><span class="required-mark">*</span></label><div class="form-group col-sm-6"><select class="form-control form-control-sm required-field"><option value="32157" selected="">Dr. Dr Jay</option><option value="35276">Pruthvi</option><option value="35274">Gowri Raju</option><option value="35275">Puneeth</option><option value="35338">Dr. Philip Reed</option><option value="35339">Dr. John Clark</option><option value="39782">Dr. Kavya Prashanth</option><option value="42546">Dr. James M</option><option value="42648">Dr. TROY SCHIEBLE</option></select></div></div><div class="form-group"><label class="col-form-label"><span>Patient Name</span><span class="required-mark">*</span></label><div class="form-group col-sm-9 appointment-form-patient-name-fields"><div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" placeholder="First name" id="appointment-form-patient-fname" value=""><div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div></div><div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" placeholder="Middle name" id="appointment-form-patient-mname" value=""><div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div></div><div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" placeholder="Last name" id="appointment-form-patient-lname" value=""><div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div></div></div></div><div class="form-group"><label class="col-form-label"></label><div class="form-group col-sm-9 patient-profilepicture-wrapper"><input type="file"><img class="patient-profilepicture" src="https://files.kivihealth.com/images/signup.png"><div class="upload-wrapper"><span class="upload-button">Upload</span><span class="material-icons">photo_camera</span></div></div></div><div class="form-group"><label class="col-form-label"><span>Contact Info</span><span class="required-mark">*</span></label><div class="form-group col-sm-9 contact-wrapper"><div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" placeholder="Contact No" id="appointment-form-patient-contactno" value=""><div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div></div><input type="text" id="appointment-form-patient-emailaddress" class="form-control" placeholder="Email Id" value=""></div></div><div class="form-group"><label class="col-form-label"><span>Gender</span><span class="required-mark">*</span></label><div class="form-group col-sm-9"><div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="patient-gender-male" value="male"><label class="form-check-label" for="patient-gender-male">Male</label></div><div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="patient-gender-female" value="female"><label class="form-check-label" for="patient-gender-female">Female</label></div></div></div><div class="form-group"><label class="col-form-label"><span>Age</span></label><div class="form-group col-sm-9"><input id="appointment-form-patient-dob" type="text" class="form-control  hasDatepicker" placeholder="Date of Birth" value=""><input type="number" min="0" step="1" class="form-control" placeholder="Age (in years)" value=""></div></div><div class="form-group"><label class="col-form-label">Referred By</label><div class="form-group col-sm-9 refer-wrapper"><div class="refer-doctor-wrapper"><div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control refer-doctor-input" placeholder="Refer Doctor" value=""><div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div></div><span class="material-icons">add_circle</span></div></div></div><div class="form-group"><label class="col-form-label">Other Referrals</label><div class="form-group col-sm-9 refer-wrapper"><div class="refer-patient-wrapper"><select class="form-control form-control-sm" style="width: 40%;"><option value="1">Patient</option><option value="2">Website</option><option value="3">Others</option><option value="4">Justdial</option><option value="5">Google</option><option value="6">Kivihealth</option></select><div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" placeholder="Refer Patient" value=""><div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div></div></div></div></div><div class="form-group"><label class="col-form-label">Location</label><div class="form-group col-sm-9 refer-wrapper"><div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" placeholder="Select City" id="appointment-form-patient-location-city" value="Bangalore"><div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div></div><div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" placeholder="Select Area" value=""><div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div></div></div></div><div class="form-group"><label class="col-form-label">Address</label><div class="form-group col-sm-9"><textarea class="form-control" rows="1" placeholder="Patient Address" id="appointment-form-patient-address"></textarea></div></div><div class="form-group"><label class="col-form-label">Reason</label><div class="form-group col-sm-9"><textarea class="form-control" rows="1" placeholder="Reason for appointment"></textarea></div></div><div class="form-group"><label class="col-form-label">Case ID</label><div class="form-group col-sm-9 caseid-wrapper"><div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" placeholder="Case Id" id="appointment-form-patient-caseid" value=""><div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div></div><select class="form-control form-control-sm"><option value="1">English</option><option value="3">Hindi</option><option value="5">Kannada</option><option value="7">Marathi</option><option value="9">Tamil</option><option value="10">Telugu</option></select></div></div><div class="form-group"><label class="col-form-label">Notify Patient</label><div class="form-group col-sm-9"><div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="patient-notify-sms" value="sms"><label class="form-check-label" for="patient-notify-sms">Thanks SMS</label></div><div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="patient-notify-email" value="email"><label class="form-check-label" for="patient-notify-email">Email</label></div><div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="patient-notify-call" value="call"><label class="form-check-label" for="patient-notify-call">Call</label></div><div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="patient-notify-app" value="app" checked=""><label class="form-check-label" for="patient-notify-app">Send app link</label></div></div></div><div class="form-group"><label class="col-form-label">Notify Doctor</label><div class="form-group col-sm-9"><div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="doctor-notify-sms" value="sms"><label class="form-check-label" for="doctor-notify-sms">SMS</label></div><div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="doctor-notify-email" value="email"><label class="form-check-label" for="doctor-notify-email">Email</label></div><div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" id="doctor-notify-app" value="app"><label class="form-check-label" for="doctor-notify-app">App notification</label></div></div></div></div><div class="appointment-form-content-right  flex-forty"><div id="flexible-margin" class="form-group"><button id="patientHistory" style="visibility: hidden; width: 0px; margin: 0px; padding: 0px;">Clear me</button><label class="col-form-label mr-2">Medical History</label><div class="form-group col-sm-8"><div class="creatable-react css-2b097c-container"><span aria-live="polite" aria-atomic="false" aria-relevant="additions text" class="css-1f43avz-a11yText-A11yText"></span><div class=" css-yk16xz-control"><div class=" css-g1d714-ValueContainer"><div class=" css-1wa3eu0-placeholder">Select...</div><div class="css-b8ldur-Input"><div class="" style="display: inline-block;"><input autocapitalize="none" autocomplete="off" autocorrect="off" id="react-select-6-input" spellcheck="false" tabindex="0" type="text" aria-autocomplete="list" value="" style="box-sizing: content-box; width: 2px; background: 0px center; border: 0px; font-size: inherit; opacity: 1; outline: 0px; padding: 0px; color: inherit;"><div style="position: absolute; top: 0px; left: 0px; visibility: hidden; height: 0px; overflow: scroll; white-space: pre; font-size: 13px; font-family: &quot;SF UI Text Regular&quot;; font-weight: 400; font-style: normal; letter-spacing: normal; text-transform: none;"></div></div></div></div><div class=" css-1hb7zxy-IndicatorsContainer"><span class=" css-1okebmr-indicatorSeparator"></span><div class=" css-tlfecz-indicatorContainer" aria-hidden="true"><svg height="20" width="20" viewBox="0 0 20 20" aria-hidden="true" focusable="false" class="css-tj5bde-Svg"><path d="M4.516 7.548c0.436-0.446 1.043-0.481 1.576 0l3.908 3.747 3.908-3.747c0.533-0.481 1.141-0.446 1.574 0 0.436 0.445 0.408 1.197 0 1.615-0.406 0.418-4.695 4.502-4.695 4.502-0.217 0.223-0.502 0.335-0.787 0.335s-0.57-0.112-0.789-0.335c0 0-4.287-4.084-4.695-4.502s-0.436-1.17 0-1.615z"></path></svg></div></div></div></div></div></div><div class="form-group"><button id="patientProcedures" style="visibility: hidden; width: 0px; margin: 0px; padding: 0px;">Clear me</button><label class="col-form-label">Procedures</label><div class="form-group col-sm-8"><div class="creatable-react css-2b097c-container"><span aria-live="polite" aria-atomic="false" aria-relevant="additions text" class="css-1f43avz-a11yText-A11yText"></span><div class=" css-yk16xz-control"><div class=" css-g1d714-ValueContainer"><div class=" css-1wa3eu0-placeholder">Select...</div><div class="css-b8ldur-Input"><div class="" style="display: inline-block;"><input autocapitalize="none" autocomplete="off" autocorrect="off" id="react-select-5-input" spellcheck="false" tabindex="0" type="text" aria-autocomplete="list" value="" style="box-sizing: content-box; width: 2px; background: 0px center; border: 0px; font-size: inherit; opacity: 1; outline: 0px; padding: 0px; color: inherit;"><div style="position: absolute; top: 0px; left: 0px; visibility: hidden; height: 0px; overflow: scroll; white-space: pre; font-size: 13px; font-family: &quot;SF UI Text Regular&quot;; font-weight: 400; font-style: normal; letter-spacing: normal; text-transform: none;"></div></div></div></div><div class=" css-1hb7zxy-IndicatorsContainer"><span class=" css-1okebmr-indicatorSeparator"></span><div class=" css-tlfecz-indicatorContainer" aria-hidden="true"><svg height="20" width="20" viewBox="0 0 20 20" aria-hidden="true" focusable="false" class="css-tj5bde-Svg"><path d="M4.516 7.548c0.436-0.446 1.043-0.481 1.576 0l3.908 3.747 3.908-3.747c0.533-0.481 1.141-0.446 1.574 0 0.436 0.445 0.408 1.197 0 1.615-0.406 0.418-4.695 4.502-4.695 4.502-0.217 0.223-0.502 0.335-0.787 0.335s-0.57-0.112-0.789-0.335c0 0-4.287-4.084-4.695-4.502s-0.436-1.17 0-1.615z"></path></svg></div></div></div></div></div></div><div class="form-group"><button id="patientGroups" style="visibility: hidden; width: 0px; margin: 0px; padding: 0px;">Clear me</button><label class="col-form-label">Groups</label><div class="form-group col-sm-8"><div class="creatable-react css-2b097c-container"><span aria-live="polite" aria-atomic="false" aria-relevant="additions text" class="css-1f43avz-a11yText-A11yText"></span><div class=" css-yk16xz-control"><div class=" css-g1d714-ValueContainer"><div class=" css-1wa3eu0-placeholder">Select...</div><div class="css-b8ldur-Input"><div class="" style="display: inline-block;"><input autocapitalize="none" autocomplete="off" autocorrect="off" id="react-select-7-input" spellcheck="false" tabindex="0" type="text" aria-autocomplete="list" value="" style="box-sizing: content-box; width: 2px; background: 0px center; border: 0px; font-size: inherit; opacity: 1; outline: 0px; padding: 0px; color: inherit;"><div style="position: absolute; top: 0px; left: 0px; visibility: hidden; height: 0px; overflow: scroll; white-space: pre; font-size: 13px; font-family: &quot;SF UI Text Regular&quot;; font-weight: 400; font-style: normal; letter-spacing: normal; text-transform: none;"></div></div></div></div><div class=" css-1hb7zxy-IndicatorsContainer"><span class=" css-1okebmr-indicatorSeparator"></span><div class=" css-tlfecz-indicatorContainer" aria-hidden="true"><svg height="20" width="20" viewBox="0 0 20 20" aria-hidden="true" focusable="false" class="css-tj5bde-Svg"><path d="M4.516 7.548c0.436-0.446 1.043-0.481 1.576 0l3.908 3.747 3.908-3.747c0.533-0.481 1.141-0.446 1.574 0 0.436 0.445 0.408 1.197 0 1.615-0.406 0.418-4.695 4.502-4.695 4.502-0.217 0.223-0.502 0.335-0.787 0.335s-0.57-0.112-0.789-0.335c0 0-4.287-4.084-4.695-4.502s-0.436-1.17 0-1.615z"></path></svg></div></div></div></div></div></div><div class="form-group"><label class="col-form-label">Blood group</label><div class="form-group col-sm-8"><select class="form-control form-control-sm"><option value="">Select</option><option value="A+">A+</option><option value="A-">A-</option><option value="B+">B+</option><option value="B-">B-</option><option value="AB+">AB+</option><option value="AB-">AB-</option><option value="O+">O+</option><option value="O-">O-</option></select></div></div><div class="form-group col-sm-12 tele-appointment"><span class="col-sm-4"></span><div class="form-check form-check-inline col-sm-8"><input class="form-check-input" type="checkbox" id="appointment-type-tele" value="yes"><label class="form-check-label" for="appointment-type-tele">Tele Appointment</label></div></div><button id="appointmentLegalId" style="visibility: hidden; height: 0px; padding: 0px; margin: 0px; width: 0px;">Clear me</button><div id="flexible-margin" class="form-group"><label class="col-form-label mr-4 paddingEM">Id type</label><select class="form-control form-control-sm"><option value="">None</option><option value="1">Aadhar card</option><option value="2">Pan card</option><option value="3">Voter Card</option><option value="4">Driving License</option><option value="5">Passport</option></select></div><div id="flexible-margin" class="form-group"><label class="col-form-label mr-4 paddingEM">Id number</label><input class="form-control" type="text" placeholder="Enter your id number" value=""></div><div class="form-group"><label class="col-form-label" for="appointment-form-patient-nh-id">NH ID</label><div class="form-group col-sm-8"><input type="text" id="appointment-form-patient-nh-id" class="form-control" placeholder="NH ID" value=""></div></div><div class="form-group"><label class="col-form-label">Other History</label><div class="form-group col-sm-8"><textarea class="form-control" rows="3" placeholder="Write history of patient"></textarea></div></div></div></div><div class="appointment-form-footer"><div class="appointment-form-footer-left"><div class="form-group col-sm-12"></div></div>
            <div class="appointment-form-footer-right">
            <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
        </div>
            <div class="button-wrapper"><div class="button-cancel"><span>Reset Form</span></div><div class="button-save"><span>Book Appointment</span></div></div></div></div></form></div></div>
          <!-- Add your form fields here -->
        </div>
        
      </div>
    </div>
  </div>
</body>

</html>
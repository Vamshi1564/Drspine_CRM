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

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

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


                <div class="pt-4 text-center">
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
          left: 'prev,today,next',
          center: 'title',
          right: '4 days,week,month,next'
        },
        defaultView: 'agendaDay',
        slotDuration: '00:10:00', // Set your default slot duration here
        minTime: '08:00:00',
        maxTime: '18:00:00',
        // Add your events data here
        events: [
          // Your events data goes here
        ],
        customButtons: {
    next4Days: {
      text: 'Next 4 Days',
      click: function() {
        var today = moment().startOf('day');
        var fourDaysLater = today.clone().add(4, 'days');
        calendar.fullCalendar('gotoDate', today);
        calendar.fullCalendar('changeView', 'agendaWeek');
        calendar.fullCalendar('option', 'visibleRange', { start: today, end: fourDaysLater });
      }
    }
  },
  // Add the custom button to the header
  customButtonGroup: 'right',
  customButtons: {
    next4Days: {
      text: 'Next 4 Days',
      click: function() {
        var today = moment().startOf('day');
        var fourDaysLater = today.clone().add(4, 'days');
        calendar.fullCalendar('gotoDate', today);
        calendar.fullCalendar('changeView', 'agendaWeek');
        calendar.fullCalendar('option', 'visibleRange', { start: today, end: fourDaysLater });
      }
    }
  }
});
     


      

      // Function to open the appointment form popup
    function openAppointmentFormPopup(date, jsEvent, view) {
      // You can display your appointment form here as a popup
      $('#appointmentFormModal').modal('show');
    }

    // Bind the click event handler to individual slots
    $('#calendar').on('click', '.fc-slats td', function() {
      var slotTime = $(this).data('time'); // Get the time of the clicked slot
      openAppointmentFormPopup(slotTime, null, null);
    });
  });
</script>

  <!--  Modal for the Appointment Form -->
  <div class="modal fade" id="appointmentFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="width:1200px;height:800px">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <!-- Your appointment form HTML goes here -->
        <!-- Replace this with your actual form HTML -->
        <div class="modal-body" style="width:1000px;height:1000px">
          <!-- Your form content goes here -->
          <h3>Appointment Form</h3>
          <div id="appointment-form" style="left: 0px;">
            <div class="appointment-form-wrapper" style="width: 1000px;">
            <form class="form-horizontal" method="POST" action="drspine_appointment_insertdb.php">
    <div class="appointment-form-header">
        <div class="appointment-form-header-left" style="text-align: right;">
            <div class="active"><span>Appointment</span></div>
            <div class=""><span>Event</span></div>
        </div>

        <div class="appointment-form-header-right" style="display: flex;">
            <div id="appointment-date-picker" class="selected-date-time-wrapper"><span class="selected-date-time">Wednesday 4th Oct, 2023 at 08:55 AM</span></div>
            <div><select class="form-control form-control-sm selected-duration" name="duration_minutes">
                <option value="5" selected="">05 Minutes</option>
                <option value="10">10 Minutes</option>
                <option value="15">15 Minutes</option>
                <option value="20">20 Minutes</option>
                <option value="30">30 Minutes</option>
                <option value="45">45 Minutes</option>
                <option value="60">1 Hour</option>
                <option value="90">1 Hours 30 Minutes</option>
                <option value="120">2 Hours</option>
                <option value="150">2 Hours 30 Minutes</option>
                <option value="180">3 Hours</option>
            </select></div>
        </div>
    </div>
    <div class="appointment-form-content" style="width: 1000px;">
        <div class="appointment-form-content-left flex-sixty">
            <div class="form-group"><label class="col-form-label"><span>Doctor</span><span class="required-mark">*</span></label>
                <div class="form-group col-sm-6"><select class="form-control form-control-sm required-field" name="doctor_name">
                    <option value="32157" selected="">Dr. Dr Jay</option>
                    <option value="35276">Pruthvi</option>
                    <option value="35274">Gowri Raju</option>
                    <option value="35275">Puneeth</option>
                    <option value="35338">Dr. Philip Reed</option>
                    <option value="35339">Dr. John Clark</option>
                    <option value="39782">Dr. Kavya Prashanth</option>
                    <option value="42546">Dr. James M</option>
                    <option value="42648">Dr. TROY SCHIEBLE</option>
                </select></div>
            </div>
            <div class="form-group"><label class="col-form-label"><span>Patient Name</span><span class="required-mark">*</span></label>
                <div class="form-group col-sm-9 appointment-form-patient-name-fields">
                    <div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" placeholder="First name" id="appointment-form-patient-fname" name="patient_first_name">
                        <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                    </div>
                    <div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" placeholder="Middle name" id="appointment-form-patient-mname" name="patient_middle_name">
                        <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                    </div>
                    <div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" placeholder="Last name" id="appointment-form-patient-lname" name="patient_last_name">
                        <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                    </div>
                </div>
            </div>
            <div class="form-group"><label class="col-form-label"></label>
                <div class="form-group col-sm-9 patient-profilepicture-wrapper"><input type="file"><img class="patient-profilepicture" src="https://files.kivihealth.com/images/signup.png">
                    <div class="upload-wrapper"><span class="upload-button">Upload</span><span class="material-icons">photo_camera</span></div>
                </div>
            </div>
            <div class="form-group"><label class="col-form-label"><span>Contact Info</span><span class="required-mark">*</span></label>
                <div class="form-group col-sm-9 contact-wrapper">
                    <div class="react-autosuggest__container"><input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" placeholder="Contact No" id="appointment-form-patient-contactno" name="contact_no">
                        <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                    </div><input type="text" id="appointment-form-patient-emailaddress" class="form-control" placeholder="Email Id" name="email_address">
                </div>
            </div>
            <div class="form-group"><label class="col-form-label"><span>Gender</span><span class="required-mark">*</span></label>
                <div class="form-group col-sm-9">
                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="gender" id="inlineRadio1" value="Male"><label class="form-check-label" for="inlineRadio1"><span>Male</span></label></div>
                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="gender" id="inlineRadio2" value="Female"><label class="form-check-label" for="inlineRadio2"><span>Female</span></label></div>
                    <div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="gender" id="inlineRadio3" value="Other"><label class="form-check-label" for="inlineRadio3"><span>Other</span></label></div>
                </div>
            </div>
            <div class="form-group"><label class="col-form-label"><span>Date of Birth</span><span class="required-mark">*</span></label>
                <div class="form-group col-sm-9">
                    <input type="text" class="form-control required-field" placeholder="Date of Birth" name="date_of_birth">
                </div>
            </div>
            <div class="form-group"><label class="col-form-label"><span>Age</span></label>
                <div class="form-group col-sm-3">
                    <input type="text" class="form-control" name="age">
                </div>
            </div>
            <div class="form-group"><label class="col-form-label"><span>Blood Group</span></label>
                <div class="form-group col-sm-3">
                    <select class="form-control form-control-sm" name="blood_group">
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                    </select>
                </div>
            </div>
            <div class="form-group"><label class="col-form-label"><span>Weight</span></label>
                <div class="form-group col-sm-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="weight">
                        <div class="input-group-append"><span class="input-group-text">Kg</span></div>
                    </div>
                </div>
            </div>
            <div class="form-group"><label class="col-form-label"><span>Height</span></label>
                <div class="form-group col-sm-3">
                    <div class="input-group">
                        <input type="text" class="form-control" name="height">
                        <div class="input-group-append"><span class="input-group-text">cm</span></div>
                    </div>
                </div>
            </div>
            <div class="form-group"><label class="col-form-label"><span>Medical History</span></label>
                <div class="form-group col-sm-9">
                    <textarea class="form-control" rows="4" name="medical_history"></textarea>
                </div>
            </div>
            <div class="form-group"><label class="col-form-label"><span>Chief Complaint</span><span class="required-mark">*</span></label>
                <div class="form-group col-sm-9">
                    <textarea class="form-control required-field" rows="4" name="chief_complaint"></textarea>
                </div>
            </div>
            <div class="form-group"><label class="col-form-label"><span>Appointment Notes</span></label>
                <div class="form-group col-sm-9">
                    <textarea class="form-control" rows="4" name="appointment_notes"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-form-label"><span>Appointment Type</span><span class="required-mark">*</span></label>
                <div class="form-group col-sm-6">
                    <select class="form-control form-control-sm" name="appointment_type">
                        <option value="regular">Regular</option>
                        <option value="event">Event</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-form-label"><span>Appointment Date and Time</span><span class="required-mark">*</span></label>
                <div class="form-group col-sm-9">
                    <input type="text" class="form-control required-field" placeholder="Date and Time" name="appointment_date_time" value="">
                </div>
            </div>
            <div class="form-group">
                <label class="col-form-label"><span>Duration</span><span class="required-mark">*</span></label>
                <div class="form-group col-sm-9">
                    <select class="form-control form-control-sm selected-duration" name="duration_minutes">
                        <!-- ... (options) ... -->
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-form-label"><span>Priority</span></label>
                <div class="form-group col-sm-6">
                    <select class="form-control form-control-sm" name="priority">
                        <option value="high">High</option>
                        <option value="medium">Medium</option>
                        <option value="low">Low</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="appointment-form-footer">
        <button type="submit" class="btn btn-primary">Create Appointment</button>
    </div>
</form>

            </div>
          </div>
          <!-- Add your form fields here -->
        </div>

      </div>
    </div>
  </div>
</body>

</html>
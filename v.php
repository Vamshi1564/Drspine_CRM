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
<!--   
<link href="https://cdn.kivihealth.com/jqueryui/1.11.4/jquery-ui.min.css" rel="stylesheet">
    <link href="https://files.kivihealth.com/assets/bootstrap4/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://files.kivihealth.com/assets/bootstrap4/css/bootstrap-override.css" rel="stylesheet">
    <link rel="stylesheet" href="https://files.kivihealth.com/assets/css/material-font.css?v=1.0.21" />
    <link href="https://files.kivihealth.com/assets/navigation/css/navigation-sidebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://files.kivihealth.com/assets/navigation/css/sidebar.css?v=2.1.55">
    <link href="/assets/offlinejs/css/offline-theme-slide.css" rel="stylesheet" />
    <link href="/assets/offlinejs/css/offline-language-english.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="https://files.kivihealth.com/assets/css/daterangepicker.css?v=1.0.58" />


    <link rel="stylesheet" href="https://files.kivihealth.com/assets/doctor/calender/css/custom-select.css?v=2.0.39" />
    <link rel="stylesheet" href="https://files.kivihealth.com/assets/doctor/calender/fullcalendar/css/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://kivihealth.com/assets/doctor/calender/css/calendar-sidebar.css?v=1.2.56" />
 -->
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
    /* Style error messages in red */
.error-message {
    color: red;
    font-size: 12px;
    margin-top: 5px;
}

/* Add red underline to placeholders when there are validation errors */
.error-message + .react-autosuggest__container input::placeholder {
    text-decoration: underline red;
}

/* Style error messages below the placeholder */
.error-message-below {
    color: red;
    font-size: 12px;
    clear: both; /* Add this property to force the element to be below the input */
    display: block; /* Add this property to make it a block-level element */
    margin-top: 5px; /* Adjust the margin-top as needed */
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
    <select class="form-control" name="branchSelector" id="branchSelector" onchange="onBranchSelect(this.value)">
      <option value="whitefield">WhiteField</option>
      <option value="BEL Road">BEL Road</option>
      <option value="Indira Nagar">Indira Nagar</option>
    </select>
    <br>
    <input type="radio" name="view" value="today" checked> Today
      <input type="radio" name="view" value="4days"> 4 Days
      <input type="radio" name="view" value="weekly"> Weekly
      <input type="radio" name="view" value="monthly"> Monthly
  </div>
</div>


<script>
    var calendar;

    // Function to fetch and initialize the calendar
    function fetchAndInitializeCalendar(branchName, view) {
  var viewOption;
  if (view === 'today') {
    // Set the view to 'agendaDay' for Today
    viewOption = 'agendaDay';
  } else if (view === '4days') {
    // Set the view to 'agendaWeek' with 4 days
    viewOption = 'agendaWeek';
  } else if (view === 'weekly') {
    // Set the view to 'agendaWeek' for Weekly
    viewOption = 'agendaWeek';
  } else if (view === 'monthly') {
    // Set the view to 'month' for Monthly
    viewOption = 'month';
  } else {
    // Default to 'agendaWeek' (weekly view)
    viewOption = 'agendaWeek';
  }

  if (view === '4days') {
    // Set the view's duration to 4 days
    calendar.fullCalendar('option', 'duration', { days: 4 });
  }

      $.ajax({
        url: 'getAPI_appointment_details.php',
        type: 'GET',
        data: { branch_name: branchName },
        success: function(data) {
          // Assuming your API returns an array of appointment objects
          var eventsData = data.map(function(appointment) {
            // Map your appointment data to FullCalendar events format
            return {
              id: appointment.id,
              title: `${appointment.patient_first_name} ${appointment.patient_last_name} - Dr. ${appointment.doctor_name}`,
              start: moment(appointment.appointment_date_time),
              end: moment(appointment.appointment_date_time).add(appointment.duration_minutes, 'minutes'),
              // Add other event properties as needed
            };
          });

          // Destroy the existing calendar instance if it exists
          if (calendar) {
            calendar.fullCalendar('destroy');
          }

          // Initialize FullCalendar with the specified view
          calendar = $('#calendar').fullCalendar({
            // FullCalendar options here
            defaultView: viewOption,
            events: eventsData,
            customButtons: {
              view4Days: {
                text: '4 Days',
                click: function() {
                  // Change the view to 'agendaWeek' with 4 days
                  calendar.fullCalendar('changeView', 'agendaWeek', { duration: { days: 4 } });
                }
              }
            },
            header: {
              left: 'prev,today,next',
              center: 'title',
              right: 'view4Days,agendaWeek,month'
            }
          });
        },
        error: function() {
          console.error('Failed to fetch appointment data from the API.');
        }
      });
    }

    // Attach an event listener to the branch selector
    document.getElementById("branchSelector").addEventListener("change", function () {
      var selectedBranch = this.value;
      var selectedView = document.querySelector('input[name="view"]:checked').value;
      
      fetchAndInitializeCalendar(selectedBranch, selectedView);
    });

    // Attach an event listener to the view selector
    document.getElementsByName("view").forEach(function (radio) {
      radio.addEventListener("change", function () {
        var selectedBranch = document.getElementById("branchSelector").value;
        var selectedView = this.value;

        fetchAndInitializeCalendar(selectedBranch, selectedView);
      });
    });

    // Initial load of the calendar for today's events and 'agendaWeek' view
    var initialBranch = document.getElementById("branchSelector").value;
    var initialView = document.querySelector('input[name="view"]:checked').value;
    fetchAndInitializeCalendar(initialBranch, initialView);
  </script>
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
    // Define the eventsData array
var eventsData = [];

// Function to fetch appointment data from the API
function fetchAppointmentData(branchName) {
 // alert(branchName);
  $.ajax({
    url: 'getAPI_appointment_details.php',
    type: 'GET',
    data: { branch_name: branchName }, // Pass the branch name as a parameter
    success: function(data) {
      // Log the received data in the console
      console.log('Received data from the API:', data);
      // Assuming your API returns an array of appointment objects like the one you provided earlier
      // Map the fetched data to the eventsData array
      eventsData = data.map(function(appointment) {
        // Calculate the end time based on the start time and a fixed duration (e.g., 10 minutes)
        var startDateTime = moment(appointment.appointment_date_time); // Parse the start time
        var durationMinutes = parseInt(appointment.duration_minutes, 10); // Parse duration_minutes as an integer
  var endDateTime = startDateTime.clone().add(durationMinutes, 'minutes'); // Add duration_minutes for the end time
        // Construct the event title with patient's name, patient ID, and doctor name
      var title = `${appointment.patient_first_name} ${appointment.patient_last_name} (ID: ${appointment.id}) - Dr. ${appointment.doctor_name}`;
        return {
          id: appointment.id,
         // title: appointment.patient_first_name + ' ' + appointment.patient_last_name,
         title: title,
          start: startDateTime.format(), // Format start time as ISO 8601
          end: endDateTime.format(),     // Format end time as ISO 8601
          // Map other fields as needed
        };
      });

      // Initialize the FullCalendar with the mapped data
      initializeFullCalendar();
    },
    error: function() {
      // Handle errors if the API request fails
      console.error('Failed to fetch appointment data from the API.');
    }
  });
}

// Function to initialize FullCalendar
function initializeFullCalendar() {
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
    editable: true, // Enable event dragging and resizing
    eventDurationEditable: true, // Allow event duration to be editable
    events: eventsData, // Use the mapped data
  
  eventDragStart: function (event, jsEvent, ui, view) {
    // This function is called when an event dragging operation starts
    // You can capture the original duration_minutes value here if needed
    event.originalDurationMinutes = event.duration_minutes;
  },

  eventDragStop: function (event, jsEvent, ui, view) {
    // This function is called when an event dragging operation stops
    // Calculate the new duration_minutes based on the drag operation
    var newDurationMinutes = event.originalDurationMinutes;

    // Update the event's duration_minutes property
    event.duration_minutes = newDurationMinutes;

    // Send an AJAX request to update the appointment's duration_minutes in your database
    $.ajax({
      url: 'update_appointment_duration.php', // Replace with your update script URL
      type: 'POST',
      data: {
        id: event.id,
        duration_minutes: newDurationMinutes
      },
      success: function (response) {
        console.log('Duration minutes updated successfully:', response.message);
      },
      error: function () {
        console.error('Failed to update duration minutes.');
        // You can handle errors here if needed
      }
    });
  },


  eventDrop: function(event, delta, revertFunc) {
    // Calculate the new end time based on the event's start time and duration
    var newEndTime = moment(event.start).add(event.duration);
    
    // Update the event's end time
    event.end = newEndTime;

    // Here, you can also send a request to update the appointment time in your database
    // Send an AJAX request to update the appointment time
    $.ajax({
      url: 'update_appointment_time.php', // Replace with your update script URL
      type: 'POST',
      data: {
        id: event.id,
        newStartTime: event.start.format(), // Send the updated start time
        newEndTime: newEndTime.format()     // Send the updated end time
      },
      success: function(response) {
        console.log('Appointment time updated successfully:', response.message);
        if (response.success) {
            sendEmailNotification(event.id);
          }
      },
      error: function() {
        console.error('Failed to update appointment time.');
        // If there's an error, you can revert the event to its original position
        revertFunc();
      }
    });
  }


  });
}

// Call the function to fetch appointment data when the document is ready
$(document).ready(function() {
  // Get the selected branch name from the hidden input field
  var branchName = document.getElementById("hiddenBranch").value;
    
    // Call and pass the branch name as an argument
    fetchAppointmentData(branchName);
  
  // Function to open the appointment form popup
  function openAppointmentFormPopup(date, jsEvent, view) {
      // You can display your appointment form here as a popup
      $('#appointmentFormModal').modal('show');
    }
    // Bind the click event handler to individual slots
    $('#calendar').on('click', '.fc-slats td', function() {
          // Get the element that was clicked
    
      var slotTime = $(this).data('time'); // Get the time of the clicked slot
      // Log the slotTime to the console
    console.log('fc slats td Clicked slot time:', slotTime);

// Show an alert with the slotTime for cross-checking
//alert('fc slats td Clicked slot time: ' + slotTime);
      openAppointmentFormPopup(slotTime, null, null);
    });
    $('#calendar').fullCalendar('refetchEventsAndRender');
});
 
    
    
</script>
<script>
        // JavaScript to update the hidden input field when a branch is selected
        document.getElementById("branchSelector").addEventListener("change", function() {
            // Get the selected branch value
            var selectedBranch = this.value;
            
            // Set the value of the hidden input field to the selected branch
            document.getElementById("hiddenBranch").value = selectedBranch;
           // alert(selectedBranch);
            fetchAppointmentData(selectedBranch);
            
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
            <input type="hidden" name="branch_name" id="hiddenBranch" value="whitefield">
                <div class="appointment-form-header">
                  <div class="appointment-form-header-left" style="text-align: right;">
                    <div class="active"><span>Appointment</span></div>
                    <div class=""><span>Event</span></div>
                  </div>

                  <div class="appointment-form-header-right" style="display: flex;">
                  <div class="daterangepicker ltr single opensleft show-calendar" style="top: 53.217px; left: auto; right: 391.163px; display: block;"><div class="ranges"></div><div class="drp-calendar left single" style="display: block;"><div class="calendar-table"><table class="table-condensed"><thead><tr><th class="prev available"><span></span></th><th colspan="5" class="month"><select class="monthselect">
                    <option value="01">Jan</option><option value="02">Feb</option><option value="03">Mar</option>
                    <option value="04">Apr</option><option value="05">May</option><option value="06">Jun</option>
                    <option value="07">Jul</option><option value="07">Aug</option><option value="09">Sep</option>
                    <option value="10" selected="selected">Oct</option><option value="11">Nov</option>
                    <option value="12">Dec</option></select>
                    <select class="yearselect"><option value="1923">1923</option><option value="1924">1924</option><option value="1925">1925</option><option value="1926">1926</option><option value="1927">1927</option><option value="1928">1928</option><option value="1929">1929</option><option value="1930">1930</option><option value="1931">1931</option><option value="1932">1932</option><option value="1933">1933</option><option value="1934">1934</option><option value="1935">1935</option><option value="1936">1936</option><option value="1937">1937</option><option value="1938">1938</option><option value="1939">1939</option><option value="1940">1940</option><option value="1941">1941</option><option value="1942">1942</option><option value="1943">1943</option><option value="1944">1944</option><option value="1945">1945</option><option value="1946">1946</option><option value="1947">1947</option><option value="1948">1948</option><option value="1949">1949</option><option value="1950">1950</option><option value="1951">1951</option><option value="1952">1952</option><option value="1953">1953</option><option value="1954">1954</option><option value="1955">1955</option><option value="1956">1956</option><option value="1957">1957</option><option value="1958">1958</option><option value="1959">1959</option><option value="1960">1960</option><option value="1961">1961</option><option value="1962">1962</option><option value="1963">1963</option><option value="1964">1964</option><option value="1965">1965</option><option value="1966">1966</option><option value="1967">1967</option><option value="1968">1968</option><option value="1969">1969</option><option value="1970">1970</option><option value="1971">1971</option><option value="1972">1972</option><option value="1973">1973</option><option value="1974">1974</option><option value="1975">1975</option><option value="1976">1976</option><option value="1977">1977</option><option value="1978">1978</option><option value="1979">1979</option><option value="1980">1980</option><option value="1981">1981</option><option value="1982">1982</option><option value="1983">1983</option><option value="1984">1984</option><option value="1985">1985</option><option value="1986">1986</option><option value="1987">1987</option><option value="1988">1988</option><option value="1989">1989</option><option value="1990">1990</option><option value="1991">1991</option><option value="1992">1992</option><option value="1993">1993</option><option value="1994">1994</option><option value="1995">1995</option><option value="1996">1996</option><option value="1997">1997</option><option value="1998">1998</option><option value="1999">1999</option><option value="2000">2000</option><option value="2001">2001</option><option value="2002">2002</option><option value="2003">2003</option><option value="2004">2004</option><option value="2005">2005</option><option value="2006">2006</option><option value="2007">2007</option><option value="2008">2008</option><option value="2009">2009</option><option value="2010">2010</option><option value="2011">2011</option><option value="2012">2012</option><option value="2013">2013</option><option value="2014">2014</option><option value="2015">2015</option><option value="2016">2016</option><option value="2017">2017</option><option value="2018">2018</option><option value="2019">2019</option><option value="2020">2020</option><option value="2021">2021</option><option value="2022">2022</option><option value="2023" selected="selected">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option><option value="2031">2031</option><option value="2032">2032</option><option value="2033">2033</option><option value="2034">2034</option><option value="2035">2035</option><option value="2036">2036</option><option value="2037">2037</option><option value="2038">2038</option><option value="2039">2039</option><option value="2040">2040</option><option value="2041">2041</option><option value="2042">2042</option><option value="2043">2043</option><option value="2044">2044</option><option value="2045">2045</option><option value="2046">2046</option><option value="2047">2047</option><option value="2048">2048</option><option value="2049">2049</option><option value="2050">2050</option><option value="2051">2051</option><option value="2052">2052</option><option value="2053">2053</option><option value="2054">2054</option><option value="2055">2055</option><option value="2056">2056</option><option value="2057">2057</option><option value="2058">2058</option><option value="2059">2059</option><option value="2060">2060</option><option value="2061">2061</option><option value="2062">2062</option><option value="2063">2063</option><option value="2064">2064</option><option value="2065">2065</option><option value="2066">2066</option><option value="2067">2067</option><option value="2068">2068</option><option value="2069">2069</option><option value="2070">2070</option><option value="2071">2071</option><option value="2072">2072</option><option value="2073">2073</option><option value="2074">2074</option><option value="2075">2075</option><option value="2076">2076</option><option value="2077">2077</option><option value="2078">2078</option><option value="2079">2079</option><option value="2080">2080</option><option value="2081">2081</option><option value="2082">2082</option><option value="2083">2083</option><option value="2084">2084</option><option value="2085">2085</option><option value="2086">2086</option><option value="2087">2087</option><option value="2088">2088</option><option value="2089">2089</option><option value="2090">2090</option><option value="2091">2091</option><option value="2092">2092</option><option value="2093">2093</option><option value="2094">2094</option><option value="2095">2095</option><option value="2096">2096</option><option value="2097">2097</option><option value="2098">2098</option><option value="2099">2099</option><option value="2100">2100</option><option value="2101">2101</option><option value="2102">2102</option><option value="2103">2103</option><option value="2104">2104</option><option value="2105">2105</option><option value="2106">2106</option><option value="2107">2107</option><option value="2108">2108</option><option value="2109">2109</option><option value="2110">2110</option><option value="2111">2111</option><option value="2112">2112</option><option value="2113">2113</option><option value="2114">2114</option><option value="2115">2115</option><option value="2116">2116</option><option value="2117">2117</option><option value="2118">2118</option><option value="2119">2119</option><option value="2120">2120</option><option value="2121">2121</option><option value="2122">2122</option><option value="2123">2123</option></select></th><th class="next available"><span></span></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off ends available" data-title="r0c0">24</td><td class="off ends available" data-title="r0c1">25</td><td class="off ends available" data-title="r0c2">26</td>
                    <td class="off ends available" data-title="r0c3">27</td><td class="off ends available" data-title="r0c4">28</td><td class="off ends available" data-title="r0c5">29</td><td class="weekend off ends available" data-title="r0c6">30</td></tr><tr><td class="weekend available" data-title="r1c0">1</td><td class="available" data-title="r1c1">2</td><td class="available" data-title="r1c2">3</td><td class="available" data-title="r1c3">4</td><td class="available" data-title="r1c4">5</td><td class="today available" data-title="r1c5">6</td><td class="weekend available" data-title="r1c6">7</td></tr><tr><td class="weekend available" data-title="r2c0">8</td><td class="available" data-title="r2c1">9</td><td class="available" data-title="r2c2">10</td><td class="available" data-title="r2c3">11</td><td class="available" data-title="r2c4">12</td><td class="available" data-title="r2c5">13</td><td class="weekend available" data-title="r2c6">14</td></tr><tr><td class="weekend available" data-title="r3c0">15</td><td class="available" data-title="r3c1">16</td><td class="available" data-title="r3c2">17</td><td class="available" data-title="r3c3">18</td><td class="available" data-title="r3c4">19</td><td class="available" data-title="r3c5">20</td><td class="weekend available" data-title="r3c6">21</td></tr><tr><td class="weekend available" data-title="r4c0">22</td><td class="available" data-title="r4c1">23</td><td class="available" data-title="r4c2">24</td><td class="available" data-title="r4c3">25</td><td class="available" data-title="r4c4">26</td>
                    <td class=" start-date  end-date available" data-title="r4c5">27</td><td class="weekend available" data-title="r4c6">28</td></tr><tr><td class="weekend available" data-title="r5c0">29</td><td class="available" data-title="r5c1">30</td><td class="available" data-title="r5c2">31</td><td class="off ends available" data-title="r5c3">1</td><td class="off ends available" data-title="r5c4">2</td><td class="off ends available" data-title="r5c5">3</td><td class="weekend off ends available" data-title="r5c6">4</td></tr></tbody></table></div><div class="calendar-time"><select class="hourselect"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6" selected="selected">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select> : <select class="minuteselect"><option value="0">00</option><option value="5">05</option><option value="10">10</option><option value="15" selected="selected">15</option><option value="20">20</option><option value="25">25</option><option value="30">30</option><option value="35">35</option><option value="40">40</option><option value="45">45</option><option value="50">50</option><option value="55">55</option></select> <select class="ampmselect"><option value="AM">AM</option><option value="PM" selected="selected">PM</option></select></div></div><div class="drp-calendar right" style="display: none;"><div class="calendar-table"><table class="table-condensed"><thead><tr><th></th><th colspan="5" class="month"><select class="monthselect"><option value="0" disabled="disabled">Jan</option><option value="1" disabled="disabled">Feb</option><option value="2" disabled="disabled">Mar</option><option value="3" disabled="disabled">Apr</option><option value="4" disabled="disabled">May</option><option value="5" disabled="disabled">Jun</option><option value="6" disabled="disabled">Jul</option><option value="7" disabled="disabled">Aug</option><option value="8" disabled="disabled">Sep</option><option value="9">Oct</option><option value="10" selected="selected">Nov</option><option value="11">Dec</option></select><select class="yearselect"><option value="2023" selected="selected">2023</option><option value="2024">2024</option><option value="2025">2025</option><option value="2026">2026</option><option value="2027">2027</option><option value="2028">2028</option><option value="2029">2029</option><option value="2030">2030</option><option value="2031">2031</option><option value="2032">2032</option><option value="2033">2033</option><option value="2034">2034</option><option value="2035">2035</option><option value="2036">2036</option><option value="2037">2037</option><option value="2038">2038</option><option value="2039">2039</option><option value="2040">2040</option><option value="2041">2041</option><option value="2042">2042</option><option value="2043">2043</option><option value="2044">2044</option><option value="2045">2045</option><option value="2046">2046</option><option value="2047">2047</option><option value="2048">2048</option><option value="2049">2049</option><option value="2050">2050</option><option value="2051">2051</option><option value="2052">2052</option><option value="2053">2053</option><option value="2054">2054</option><option value="2055">2055</option><option value="2056">2056</option><option value="2057">2057</option><option value="2058">2058</option><option value="2059">2059</option><option value="2060">2060</option><option value="2061">2061</option><option value="2062">2062</option><option value="2063">2063</option><option value="2064">2064</option><option value="2065">2065</option><option value="2066">2066</option><option value="2067">2067</option><option value="2068">2068</option><option value="2069">2069</option><option value="2070">2070</option><option value="2071">2071</option><option value="2072">2072</option><option value="2073">2073</option><option value="2074">2074</option><option value="2075">2075</option><option value="2076">2076</option><option value="2077">2077</option><option value="2078">2078</option><option value="2079">2079</option><option value="2080">2080</option><option value="2081">2081</option><option value="2082">2082</option><option value="2083">2083</option><option value="2084">2084</option><option value="2085">2085</option><option value="2086">2086</option><option value="2087">2087</option><option value="2088">2088</option><option value="2089">2089</option><option value="2090">2090</option><option value="2091">2091</option><option value="2092">2092</option><option value="2093">2093</option><option value="2094">2094</option><option value="2095">2095</option><option value="2096">2096</option><option value="2097">2097</option><option value="2098">2098</option><option value="2099">2099</option><option value="2100">2100</option><option value="2101">2101</option><option value="2102">2102</option><option value="2103">2103</option><option value="2104">2104</option><option value="2105">2105</option><option value="2106">2106</option><option value="2107">2107</option><option value="2108">2108</option><option value="2109">2109</option><option value="2110">2110</option><option value="2111">2111</option><option value="2112">2112</option><option value="2113">2113</option><option value="2114">2114</option><option value="2115">2115</option><option value="2116">2116</option><option value="2117">2117</option><option value="2118">2118</option><option value="2119">2119</option><option value="2120">2120</option><option value="2121">2121</option><option value="2122">2122</option><option value="2123">2123</option></select></th><th class="next available"><span></span></th></tr><tr><th>Su</th><th>Mo</th><th>Tu</th><th>We</th><th>Th</th><th>Fr</th><th>Sa</th></tr></thead><tbody><tr><td class="weekend off ends available" data-title="r0c0">29</td><td class="off ends available" data-title="r0c1">30</td><td class="off ends available" data-title="r0c2">31</td><td class="available" data-title="r0c3">1</td><td class="available" data-title="r0c4">2</td><td class="available" data-title="r0c5">3</td><td class="weekend available" data-title="r0c6">4</td></tr><tr><td class="weekend available" data-title="r1c0">5</td><td class="available" data-title="r1c1">6</td><td class="available" data-title="r1c2">7</td><td class="available" data-title="r1c3">8</td><td class="available" data-title="r1c4">9</td><td class="available" data-title="r1c5">10</td><td class="weekend available" data-title="r1c6">11</td></tr><tr><td class="weekend available" data-title="r2c0">12</td><td class="available" data-title="r2c1">13</td><td class="available" data-title="r2c2">14</td><td class="available" data-title="r2c3">15</td><td class="available" data-title="r2c4">16</td><td class="available" data-title="r2c5">17</td><td class="weekend available" data-title="r2c6">18</td></tr><tr><td class="weekend available" data-title="r3c0">19</td><td class="available" data-title="r3c1">20</td><td class="available" data-title="r3c2">21</td><td class="available" data-title="r3c3">22</td><td class="available" data-title="r3c4">23</td><td class="available" data-title="r3c5">24</td><td class="weekend available" data-title="r3c6">25</td></tr><tr><td class="weekend available" data-title="r4c0">26</td><td class="available" data-title="r4c1">27</td><td class="available" data-title="r4c2">28</td><td class="available" data-title="r4c3">29</td><td class="available" data-title="r4c4">30</td><td class="off ends available" data-title="r4c5">1</td><td class="weekend off ends available" data-title="r4c6">2</td></tr><tr><td class="weekend off ends available" data-title="r5c0">3</td><td class="off ends available" data-title="r5c1">4</td><td class="off ends available" data-title="r5c2">5</td><td class="off ends available" data-title="r5c3">6</td><td class="off ends available" data-title="r5c4">7</td><td class="off ends available" data-title="r5c5">8</td><td class="weekend off ends available" data-title="r5c6">9</td></tr></tbody></table></div><div class="calendar-time"><select class="hourselect"><option value="1" disabled="disabled" class="disabled">1</option><option value="2" disabled="disabled" class="disabled">2</option><option value="3" disabled="disabled" class="disabled">3</option><option value="4" disabled="disabled" class="disabled">4</option><option value="5" disabled="disabled" class="disabled">5</option><option value="6" selected="selected">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12" disabled="disabled" class="disabled">12</option></select> : <select class="minuteselect"><option value="0" disabled="disabled" class="disabled">00</option><option value="5" disabled="disabled" class="disabled">05</option><option value="10" disabled="disabled" class="disabled">10</option><option value="15" selected="selected">15</option><option value="20">20</option><option value="25">25</option><option value="30">30</option><option value="35">35</option><option value="40">40</option><option value="45">45</option><option value="50">50</option><option value="55">55</option></select> <select class="ampmselect"><option value="AM" disabled="disabled" class="disabled">AM</option><option value="PM" selected="selected">PM</option></select></div></div><div class="drp-buttons"><span class="drp-selected">10/27/2023 - 10/27/2023</span><button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button><button class="applyBtn btn btn-sm btn-primary" type="button">Apply</button> </div></div>
                   
                    <div id="appointment-date-picker" class="selected-date-time-wrapper" name="appointment_date_time">
  <span class="selected-date-time"></span>
</div>
<!-- 
<script>
  // Function to format a date object as "Day DDth Mon, YYYY at HH:MM AM/PM"
  function formatDate(date) {
    const daysOfWeek = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
    const day = date.getDate();
    const month = date.getMonth();
    const year = date.getFullYear();
    const hours = date.getHours();
    const minutes = date.getMinutes();
    const ampm = hours >= 12 ? "PM" : "AM";

    // Format the day with "st", "nd", "rd", or "th" based on the day number
    const daySuffix = day % 10 === 1 && day !== 11 ? "st" : (day % 10 === 2 && day !== 12 ? "nd" : (day % 10 === 3 && day !== 13 ? "rd" : "th"));

    const formattedDate = `${daysOfWeek[date.getDay()]} ${day}${daySuffix} ${months[month]}, ${year} at ${hours}:${minutes.toString().padStart(2, '0')} ${ampm}`;
    return formattedDate;
  }

  // Get the current date and time
  const currentDate = new Date();

  // Display the formatted current date and time in the appointment date picker
  const appointmentDatePicker = document.getElementById('appointment-date-picker');
  const selectedDateTimeElement = appointmentDatePicker.querySelector('.selected-date-time');
  selectedDateTimeElement.textContent = formatDate(currentDate);
</script> -->

<input type="hidden" name="appointment_date_time_database" id="appointment_date_time_database" >
<input type="datetime-local" name="formatted_appointment_date_time" id="formatted_appointment_date_time" hidden>

<script>
  const appointmentDatePicker = document.getElementById('appointment-date-picker');
  const selectedDateTimeElement = appointmentDatePicker.querySelector('.selected-date-time');
  const appointmentTimeInput = document.getElementById('appointment_date_time_database');
  const formattedAppointmentTimeInput = document.getElementById('formatted_appointment_date_time');
  const dateRangePickerDiv = document.querySelector('.daterangepicker.ltr.single.opensleft.show-calendar');

  // Function to update the selected date and time
  function updateSelectedDateTime() {
    const selectedDateElement = dateRangePickerDiv.querySelector('.start-date');
    const selectedMonthElement = dateRangePickerDiv.querySelector('.monthselect');
    const selectedYearElement = dateRangePickerDiv.querySelector('.yearselect');
    const selectedHourElement = dateRangePickerDiv.querySelector('.hourselect');
    const selectedMinuteElement = dateRangePickerDiv.querySelector('.minuteselect');
    const selectedAmPmElement = dateRangePickerDiv.querySelector('.ampmselect');

    const selectedDate = selectedDateElement.textContent;
    const selectedMonth = selectedMonthElement.value;
    const selectedYear = selectedYearElement.value;
    const selectedHour = selectedHourElement.value;
    const selectedMinute = selectedMinuteElement.value;
    const selectedAmPm = selectedAmPmElement.value;

    // Format the selected date and time as yyyy-mm-dd hh:minutes:ss
    const formattedSelectedDateTime = `${selectedYear}-${selectedMonth}-${selectedDate} ${selectedHour}:${selectedMinute}:00`;
    selectedDateTimeElement.textContent = formattedSelectedDateTime;
    appointmentTimeInput.value = `${selectedYear}-${selectedMonth}-${selectedDate} ${selectedHour}:${selectedMinute}:00`;
    formattedAppointmentTimeInput.value = formattedSelectedDateTime;
  }

  // Function to hide the date range picker
  function hideDateRangePicker() {
    dateRangePickerDiv.style.display = 'block';
  }

  // Function to show the date range picker
  function showDateRangePicker() {
    dateRangePickerDiv.style.display = 'block';
  }

  // Attach a click event listener to toggle the date-time picker when clicking "appointment-date-picker"
  appointmentDatePicker.addEventListener('click', showDateRangePicker);

  // Attach click event listener to "Apply" button to hide the date range picker
  const applyBtn = dateRangePickerDiv.querySelector('.applyBtn');
  applyBtn.addEventListener('click', hideDateRangePicker);

  // Attach click event listener to "Cancel" button to hide the date range picker
  const cancelBtn = dateRangePickerDiv.querySelector('.cancelBtn');
  cancelBtn.addEventListener('click', hideDateRangePicker);

  // Attach a click event listener to hide the date range picker when clicking outside of it
  document.addEventListener('click', (event) => {
    if (event.target !== appointmentDatePicker && event.target !== dateRangePickerDiv) {
      hideDateRangePicker();
    }
  });

  // Listen for changes in the date range picker and update the selected date and time
  dateRangePickerDiv.addEventListener('change', updateSelectedDateTime);

  // Initial update
  updateSelectedDateTime();
</script>

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
                      <div class="form-group col-sm-6"><select name="doctor_name" class="form-control form-control-sm required-field">
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
                    <div class="form-group">
                      <label class="col-form-label"><span>Patient Name</span><span class="required-mark">*</span></label>
                      <div class="form-group col-sm-9 appointment-form-patient-name-fields">
                        <div class="react-autosuggest__container">
                         <input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" name="patient_first_name" placeholder="First name" id="appointment-form-patient-fname" value="">
                         <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                         <div class="error-message" id="fname-error"></div>
                        </div>
                        <div class="react-autosuggest__container">
                         <input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" name="patient_middle_name" placeholder="Middle name" id="appointment-form-patient-mname" value="">
                         <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                         <div class="error-message" id="mname-error"></div>
                       </div>
                       <div class="react-autosuggest__container">
                         <input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" name="patient_last_name" placeholder="Last name" id="appointment-form-patient-lname" value="">
                         <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                         <div class="error-message" id="lname-error"></div>
                       </div>
                      </div>
                    </div>

                    <div class="form-group"><label class="col-form-label"></label>
                      <div class="form-group col-sm-9 patient-profilepicture-wrapper"><input type="file" name="patient_profile_picture"><img class="patient-profilepicture" src="https://files.kivihealth.com/images/signup.png">
                        <div class="upload-wrapper"><span class="upload-button">Upload</span><span class="material-icons">photo_camera</span></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-form-label"><span>Contact Info</span><span class="required-mark">*</span></label>
                    <div class="row">
                      <div class="col-sm-6">
                           <div class="react-autosuggest__container">
                           <input type="text" name="contact_no" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" placeholder="Contact No" id="appointment-form-patient-contactno" value="">
                           <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                           <div class="error-message" id="contactno-error"></div>
                      </div>
                    </div>
                      <div class="col-sm-6">
                      <input type="text" id="appointment-form-patient-emailaddress" class="form-control" name="email_address" placeholder="Email Id" value="">
                      <div class="error-message-below" id="email-error"></div>
                   </div>
                   </div>
                   </div>
                    <div class="form-group"><label class="col-form-label"><span>Gender</span><span class="required-mark">*</span></label>
                      <div class="form-group col-sm-9">
                        <div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="patient-gender-male"  name="gender" value="male"><label class="form-check-label" for="patient-gender-male">Male</label></div>
                        <div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="patient-gender-female" name="gender" value="female"><label class="form-check-label" for="patient-gender-female">Female</label></div>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-form-label"><span>Age</span></label>
                      <div class="form-group col-sm-9"><input id="appointment-form-patient-dob" type="date"  name="date_of_birth" class="form-control  hasDatepicker" placeholder="Date of Birth" value=""><input type="number" min="0" step="1" class="form-control" placeholder="Age (in years)" value=""></div>
                    </div>

                    <div class="form-group"><label class="col-form-label">Referred By</label>
                      <div class="form-group col-sm-9 refer-wrapper">
                        <div class="refer-doctor-wrapper">
                          <div class="react-autosuggest__container">
                            <input type="text" name="referred_by" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control refer-doctor-input" placeholder="Refer Doctor" value="">
                            <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container">

                            </div>
                          </div>
                          <span class="material-icons ">add_circle</span>
                        </div>
                      </div>
                    </div>




                    <div class="form-group"><label class="col-form-label">Other Referrals</label>
                      <div class="form-group col-sm-9 refer-wrapper">
                        <div class="refer-patient-wrapper"><select class="form-control form-control-sm" name="refer_patient_type" style="width: 40%;">
                            <option value="1">Patient</option>
                            <option value="2">Website</option>
                            <option value="3">Others</option>
                            <option value="4">Justdial</option>
                            <option value="5">Google</option>
                            <option value="6">Kivihealth</option>
                          </select>
                          <div class="react-autosuggest__container"><input type="text" name="refer_patient_name" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" placeholder="Refer Patient" value="">
                            <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-form-label">Location</label>
                      <div class="form-group col-sm-9 refer-wrapper">
                        <div class="react-autosuggest__container"><input type="text" name="location_city" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" placeholder="Select City" id="appointment-form-patient-location-city" value="Bangalore">
                          <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                        </div>
                        <div class="react-autosuggest__container"><input type="text" name="location_area" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" placeholder="Select Area" value="">
                          <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-form-label">Address</label>
                      <div class="form-group col-sm-9"><textarea class="form-control" name="patient_address" rows="1" placeholder="Patient Address" id="appointment-form-patient-address"></textarea></div>
                    </div>
                    <div class="form-group"><label class="col-form-label">Reason</label>
                      <div class="form-group col-sm-9"><textarea class="form-control" name="reason_for_appointment" rows="1" placeholder="Reason for appointment"></textarea></div>
                    </div>
                    <div class="form-group"><label class="col-form-label">Case ID</label>
                      <div class="form-group col-sm-9 caseid-wrapper">
                        <div class="react-autosuggest__container"><input type="text" name="case_id" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" placeholder="Case Id" id="appointment-form-patient-caseid" value="">
                          <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                        </div><select class="form-control form-control-sm">
                          <option value="1">English</option>
                          <option value="3">Hindi</option>
                          <option value="5">Kannada</option>
                          <option value="7">Marathi</option>
                          <option value="9">Tamil</option>
                          <option value="10">Telugu</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-form-label">Notify Patient</label>
                      <div class="form-group col-sm-9">
                        <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="patient-notify-sms" id="patient-notify-sms" value="sms"><label class="form-check-label" for="patient-notify-sms" style="white-space: nowrap; margin-right:1px;">Thanks SMS</label></div>
                        <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="patient-notify-email" id="patient-notify-email" value="email"><label class="form-check-label" for="patient-notify-email" style="white-space: nowrap; margin-right:1px;">Email</label></div>
                        <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="patient-notify-call" id="patient-notify-call" value="call"><label class="form-check-label" for="patient-notify-call" style="white-space: nowrap; margin-right:1px;">Call</label></div>
                        <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="patient-notify-app" id="patient-notify-app" value="app" checked=""><label class="form-check-label" for="patient-notify-app" style="white-space: nowrap; margin-right:1px;">Send app link</label></div>
                      </div>
                      
                    </div>
                    <div class="form-group"><label class="col-form-label">Notify Doctor</label>
                      <div class="form-group col-sm-9">
                        <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="doctor-notify-sms" id="doctor-notify-sms" value="sms"><label class="form-check-label" for="doctor-notify-sms">SMS</label></div>
                        <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="doctor-notify-email" id="doctor-notify-email" value="email"><label class="form-check-label" for="doctor-notify-email">Email</label></div>
                        <div class="form-check form-check-inline"><input class="form-check-input" type="checkbox" name="doctor-notify-app" id="doctor-notify-app" value="app"><label class="form-check-label" for="doctor-notify-app">App notification</label></div>
                      </div>
                    </div>
                  </div>
                  <div class="appointment-form-content-right  flex-forty">
                    
                    <div class="form-group">
                      <label class="col-form-label mr-3">Medical History</label>
                      <select class="form-control" name="medical_history">
                        <option value="">Select...</option>
                        <!-- Add medical history options here -->
                        <option value="Option 1">Option 1</option>
                        <option value="Option 2">Option 2</option>
                        <!-- Add more options as needed -->
                      </select>
                    </div>
                    

                    <div class="form-group">
                      <label class="col-form-label">Procedures</label>
                      <div class="form-group col-sm-8">
                        <select class="form-control" name="procedures">
                          <option value="">Select...</option>
                          <!-- Add procedure options here -->
                          <option value="Procedure Option 1">Procedure Option 1</option>
                          <option value="Procedure Option 2">Procedure Option 2</option>
                        </select>
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="col-form-label">Groups</label>
                      <div class="form-group col-sm-8">
                        <select class="form-control" name="groups">
                          <option value="">Select...</option>
                          <!-- Add group options here -->
                          <option value="Group Option 1">Group Option 1</option>
                          <option value="Group Option 2">Group Option 2</option>
                          <!-- Add more options as needed -->
                        </select>
                      </div>
                    </div>



                    <div class="form-group"><label class="col-form-label">Blood group</label> 
                      <div class="form-group col-sm-8"><select class="form-control form-control-sm" name="blood_group">
                          <option value="">Select</option>
                          <option value="A+">A+</option>
                          <option value="A-">A-</option>
                          <option value="B+">B+</option>
                          <option value="B-">B-</option>
                          <option value="AB+">AB+</option>
                          <option value="AB-">AB-</option>
                          <option value="O+">O+</option>
                          <option value="O-">O-</option>
                        </select></div>
                    </div>
                    <div class="form-group col-sm-12 tele-appointment"><span class="col-sm-4"></span>
                      <div class="form-check form-check-inline col-sm-8"><input class="form-check-input" type="checkbox" name="appointment-type-tele" id="appointment-type-tele" value="yes"><label class="form-check-label" for="appointment-type-tele">Tele Appointment</label></div>
                    </div><button id="appointmentLegalId" style="visibility: hidden; height: 0px; padding: 0px; margin: 0px; width: 0px;">Clear me</button>
                    <div id="flexible-margin" class="form-group"><label class="col-form-label mr-4 paddingEM">Id type</label><select class="form-control form-control-sm" name="id_type">
                        <option value="">None</option>
                        <option value="1">Aadhar card</option>
                        <option value="2">Pan card</option>
                        <option value="3">Voter Card</option>
                        <option value="4">Driving License</option>
                        <option value="5">Passport</option>
                      </select></div>
                    <div id="flexible-margin" class="form-group"><label class="col-form-label mr-4 paddingEM">Id number</label><input class="form-control" type="text" name="id_number" placeholder="Enter your id number" value=""></div>
                    <div class="form-group"><label class="col-form-label" for="appointment-form-patient-nh-id">NH ID</label>
                      <div class="form-group col-sm-8"><input type="text" name="nh_id" id="appointment-form-patient-nh-id" class="form-control" placeholder="NH ID" value=""></div>
                    </div>
                    <div class="form-group"><label class="col-form-label">Other History</label>
                      <div class="form-group col-sm-8"><textarea class="form-control" name="other_history" rows="3" placeholder="Write history of patient"></textarea></div>
                    </div>
                  </div>
                </div>
                <div class="appointment-form-footer">
                  <div class="appointment-form-footer-left">
                    <div class="form-group col-sm-12"></div>
                  </div>
                  <div class="appointment-form-footer-right">
                    
                    <div class="button-wrapper" style="text-align: right;">
                      <div class="button-save" style="display: inline-block;">
                      <button type="submit">Book Appointment</button></div>
                      <div class="button-cancel" style="display: inline-block;">Reset Form</div>
                      <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      
                    </div>
                    </div>



                    <style>
                      .button-save {
                        white-space: nowrap;
                      }

                      .button-cancel {
                        white-space: nowrap;
                      }
                    </style>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <!-- Add your form fields here -->
        </div>

      </div>
    </div>
  </div>
  <script>
// Get references to the input fields and error message elements
const firstNameInput = document.getElementById("appointment-form-patient-fname");
const middleNameInput = document.getElementById("appointment-form-patient-mname");
const lastNameInput = document.getElementById("appointment-form-patient-lname");
const fnameError = document.getElementById("fname-error");
const mnameError = document.getElementById("mname-error");
const lnameError = document.getElementById("lname-error");
const contactNoInput = document.getElementById("appointment-form-patient-contactno");
const contactNoError = document.getElementById("contactno-error");

const emailAddressInput = document.getElementById("appointment-form-patient-emailaddress");
const emailError = document.getElementById("email-error");

// Regular expression to match valid names (letters and spaces only)
const nameRegex = /^[A-Za-z\s]+$/;

// Function to validate the name input
function validateNameInput(input, errorElement) {
    if (input.value.trim() === "") {
        errorElement.textContent = ""; // Clear the error message if input is empty
    } else if (!nameRegex.test(input.value)) {
        errorElement.textContent = "Enter a valid name";
    } else {
        errorElement.textContent = ""; // Clear the error message
    }
}

// Add event listeners for input validation
firstNameInput.addEventListener("input", function () {
    validateNameInput(firstNameInput, fnameError);
});

middleNameInput.addEventListener("input", function () {
    validateNameInput(middleNameInput, mnameError);
});

lastNameInput.addEventListener("input", function () {
    validateNameInput(lastNameInput, lnameError);
});


// Regular expression to match valid contact numbers (digits, and optional country code)
const contactNoRegex = /^\+?\d{1,15}$/;


// Regular expression to match valid email addresses
const emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

contactNoInput.addEventListener("input", function () {
    if (contactNoInput.value.trim() === "") {
        contactNoError.textContent = ""; // Clear the error message if input is empty
    } else if (!contactNoRegex.test(contactNoInput.value)) {
        contactNoError.textContent = "Enter a valid number";
    } else {
        contactNoError.textContent = ""; // Clear the error message
    }
});

emailAddressInput.addEventListener("input", function () {
    if (emailAddressInput.value.trim() === "") {
        emailError.textContent = ""; // Clear the error message if input is empty
    } else if (!emailRegex.test(emailAddressInput.value)) {
        emailError.textContent = "Enter a valid email";
    } else {
        emailError.textContent = ""; // Clear the error message
    }
});

</script>
</body>

</html>
//   eventDrop: function(event, delta, revertFunc) {
//   // Calculate the new start and end times
//   var newStart = event.start.clone().add(delta);
//   var newEnd = event.end.clone().add(delta);

//   // Send a POST request to update the appointment time
//   $.ajax({
//     url: 'update_appointment_time.php',
//     type: 'POST',
//     data: {
//       newStartTime: newStart.format(),
//       newEndTime: newEnd.format(),
//       eventId: event.id // Assuming event.id is the appointment ID
//     },
//     success: function(response) {
//       // Handle the success response from the server (if needed)
//       console.log('Appointment time updated successfully:', response);
//     },
//     error: function(xhr, status, error) {
//       // Handle errors if the request fails
//       console.error('Failed to update appointment time:', error);
//       revertFunc(); // Revert the event drop if there was an error
//     }
//   });
// }
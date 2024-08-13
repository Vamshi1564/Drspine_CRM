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
    <select class="form-control" name="branchSelector" id="branchSelector" >
      <option value="whitefield" selected>WhiteField</option>
      <option value="BEL Road">BEL Road</option>
      <option value="Indira Nagar">Indira Nagar</option>
    </select>
    <br>
    <input type="radio" name="view" value="today" checked> Today
      <!-- <input type="radio" name="view" value="4days"> 4 Days -->
      <input type="radio" name="view" value="weekly"> Weekly
      <input type="radio" name="view" value="monthly"> Monthly
  </div>
</div>


<script>
    var calendar;

    
    function fetchAndInitializeCalendar(branchName, view) {
  var viewOption;
  if (view === 'today') {
    // Set the view to 'agendaDay' for Today
    viewOption = 'agendaDay';
  } else if (view === '4days') {
    // Set the view to 'agendaWeek' with 4 days
    viewOption = '4days';
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

//   if (view === '4days') {
//     // Set the view's duration to 4 days
//     calendar.fullCalendar('option', 'duration', { days: 4 });
//   }

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
              title: `${appointment.patient_first_name} ${appointment.patient_last_name} (ID: ${appointment.id}) - Dr. ${appointment.doctor_name}`,
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
              right: 'view4Days,agendaWeek,month,next'
            },slotDuration: '00:10:00', // Set your default slot duration here
    minTime: '08:00:00',
    maxTime: '22:00:00',
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


  eventResize: function(event, delta, revertFunc) {
  // Calculate the new duration in minutes
  var newDurationMinutes = event.end.diff(event.start, 'minutes');

  console.log('New Duration Minutes:', newDurationMinutes);

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
      
      const branchSelector = document.getElementById('branchSelector');
    const doctorSelector = document.getElementById('doctorSelector');

        fetchDocotrsAPI(selectedBranch);
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
    function fetchDocotrsAPI(selectedBranch)
    {
      // Make an AJAX request to fetch doctors based on the selected branch
      fetch(`fetch_doctors.php?branch_name=${selectedBranch}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                  console.log(data);
                    const doctors = data.doctors;

                    // Clear the existing doctor options
                    doctorSelector.innerHTML = '';

                    // Add the new doctor options based on the response
                    doctors.forEach(doctor => {
                        const option = document.createElement('option');
                       // option.value = doctor.id;
                       option.value = doctor.doctor_name;
                        option.textContent = doctor.doctor_name;
                        doctorSelector.appendChild(option);
                    });
                } else {
                    console.error('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching doctors:', error);
            });
    
    }
  </script>
                
                <!-- /.card-header -->


                <!-- <div class="pt-4 text-center">
                  <label for="slotDurationSelect">Select Slot Duration: </label>
                  <select id="slotDurationSelect">
                    <option value="00:10:00">10 minutes</option>
                    <option value="00:15:00">15 minutes</option>
                    <option value="00:30:00">30 minutes</option>
                  </select>
                </div> -->
                <!-- form start -->
                <div class="card-body">
                  <div id="calendar"></div>
                  <div id="eventDetailsModal" class="modal">
  <div class="modal-content">
    <!-- <h4>Patient Details</h4> -->
    <div id="patient_details_modal" style="
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  border-radius: 5px;
  width: 80%;
  max-width: 500px;
  position: absolute;
  top: 4%;
  left: 100%;
  transform: translate(+30%, +70%);
  padding: 20px;">
    <p style="color:blue" id="patientFirstName"></p>
    <p id="contactNumber"></p>
    <div class="row">
    <div class="col-md-6">
    <p id="doctorName"></p> 
    </div>
    <div class="col-md-6">
  <button class="custom-btn blue-text">Edit</button>
  <button class="custom-btn red-text">Delete</button>
</div>
 </div>
 
    <p id="appointmentTime"></p>
    <div class="modal-footer">
      <button class="btn red" id="cancelBtn">Cancel</button>
      <button class="btn yellow" id="missedBtn">Missed</button>
      <button class="btn blue" id="followBtn">Follow</button>
      <button class="btn green" id="paymentBtn">Payment</button>

      <button class="btn" id="closeModalBtn">Close</button>
    </div>
  </div>
  </div>
  </div>

                 

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
      
// Refresh the calendar
//calendar.refetchEvents();
    },
    error: function() {
      // Handle errors if the API request fails
      console.error('Failed to fetch appointment data from the API.');
    }
  });
 

}



$('#calendar').on('click', '.fc-event', function () {
  var title = $(this).text(); // Get the text of the clicked event
  console.log('Clicked event title:', title); // Log the event title

  
  var eventId = extractIdFromTitle(title);

  if (eventId !== null) {
    // Send an AJAX request to fetch additional data based on the event ID
    $.ajax({
      url: 'get_patientdetails_with_id.php',
      type: 'GET',
      data: { id: eventId },
      success: function (data) {
        console.log("Successful return from the PHP page", data);

        // Assuming your API returns the data for the clicked event
        var appointmentInfo = data;
        try {
          // Parse the date string (assuming $appointment_date_time is a string)
          var date = new Date(appointmentInfo.appointment_date_time);

          if (!isNaN(date.getTime())) {
            // Format the date as per your desired format
            var options = {
              weekday: 'long',
              day: 'numeric',
              month: 'short',
              year: 'numeric',
              hour: 'numeric',
              minute: 'numeric',
              hour12: true,
            };
            var formatted_date = date.toLocaleString('en-US', options);
            // console.log(formatted_date); // Output: "Sunday, Oct 8, 2023, 9:55 AM"
            
            // You can assign the formatted date to a variable or use it as needed.
            appointmentInfo.appointment_date_time = formatted_date;
          } else {
            console.error("Failed to parse date and time.");
          }
        } catch (error) {
          console.error("Error: " + error.message);
        }

        // Update the modal with the fetched data
        var patientFirstNameLink = $('<a>')
          .attr('href', 'view_single_patient_details.php?patient_id=' + appointmentInfo.patient_id)
          .text(appointmentInfo.patient_first_name);
        $('#patientFirstName').empty().append(patientFirstNameLink);

        $('#contactNumber').text(' ' + appointmentInfo.contact_no);
        $('#doctorName').text('' + appointmentInfo.doctor_name);
        $('#appointmentTime').text('' + appointmentInfo.appointment_date_time);

        // Show the modal
        $('#eventDetailsModal').show();
      },
      error: function () {
        console.error('Failed to fetch additional event data.');
      }
    });
  }
});

// Hide the modal when the close button is clicked
$('#eventDetailsModal #closeModalBtn').click(function () {
  $('#eventDetailsModal').hide();
});
function extractIdFromTitle(title) {
  // Use a regular expression to extract the ID value enclosed in parentheses
  var idMatch = title.match(/\(ID: (\d+)\)/);

  // Check if a match was found and return the ID value if available
  if (idMatch && idMatch[1]) {
    return idMatch[1]; // Extracted ID value
  } else {
    return null; // Return null if no ID value is found
  }
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
    minTime: '06:00:00',
    maxTime: '22:00:00',
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

eventResize: function(event, delta, revertFunc) {
  // Calculate the new duration in minutes
  var newDurationMinutes = event.end.diff(event.start, 'minutes');

  console.log('New Duration Minutes:', newDurationMinutes);

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

  });
}

// Call the function to fetch appointment data when the document is ready
$(document).ready(function() {
  fetchDocotrsAPI("whitefield");

    
// Get all date cells with the "available" class
const dateCells = document.querySelectorAll('td.available');

// Get the date table cell
const dateTableCell = document.querySelector('#date-time-table tbody td:nth-child(1)');

// Define a selectedDate variable to store the selected date
var selectedDate_td = ''; // Initialize it with an empty string

// Add click event listeners to date cells
dateCells.forEach((cell) => {
  cell.addEventListener('click', () => {
    
    selectedDate_td = cell.textContent; // Update the selectedDate variable

    // Update the selected date in the table cell
    dateTableCell.textContent = selectedDate_td;

    // You can use selectedDate_td here or call a function with it
    // For example, call a function to do something with selectedDate_td
    doSomethingWithSelectedDate(selectedDate_td);
  });
});

// Function to do something with the selected date
function doSomethingWithSelectedDate(date) {
  console.log('Selected date:', date);
  // You can perform additional actions with the selected date here
}


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
      <div class="modal-content" >

        <!-- Your appointment form HTML goes here -->
        <!-- Replace this with your actual form HTML -->
        <div class="modal-body" style="width:1000px;height:1000px">
          <!-- Your form content goes here -->
          <h3>Appointment Form</h3>
          <div id="appointment-form" style="left: 0px;">
            <div class="appointment-form-wrapper" style="width: 1000px;">
            <form class="form-horizontal" method="POST" action="drspine_appointment_insertdb.php">
            <input type="hidden" name="branch_name" id="hiddenBranch" value="whitefield">
            <input type="text" name="patient_id" id="patient_id" value="new_patient">
            <input type="text" id="id" name="id">
                <div class="appointment-form-header">
                  <div class="appointment-form-header-left" style="text-align: right;">
                    <div class="active"><span>Appointment</span></div>
                    <div class=""><span>Event</span></div>
                  </div>

                  <div class="appointment-form-header-right" style="display: flex;">
                  
         
    <!-- Clickable appointment-date-picker -->
    <div id="appointment-date-picker" class="selected-date-time-wrapper" onclick="showDateTimePicker()" name="appointment_date_time">
        <label for="appointment-date-picker"></label>
        <span class="selected-date-time"></span>
    </div>
    <!-- Hidden datetime-local input field -->
    <input type="datetime-local" id="datetime-picker" name="datetime-picker" style="display: none;" onchange="updateSelectedDateTime()">
    <br>
  
<input type="hidden" name="appointment_date_time_database" id="appointment_date_time_database">

    

<script>
     var datetimePicker = document.getElementById("datetime-picker");
        // Show the datetime picker
    const appointmentTimeInput = document.getElementById('appointment_date_time_database');
    var selectedDateTimeSpan = document.querySelector(".selected-date-time");

      
    // Set the default value to the current time
    var currentDateTime = new Date();
    
    var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    var dayOfWeek = days[currentDateTime.getDay()];
    var year = currentDateTime.getFullYear();
    var monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    var monthName = monthNames[currentDateTime.getMonth()];
    var day = currentDateTime.getDate();
    var hours = currentDateTime.getHours();
    var ampm = hours >= 12 ? 'PM' : 'AM';
    hours = hours % 12 || 12; // Convert to 12-hour format
    var minutes = String(currentDateTime.getMinutes()).padStart(2, '0');
    var seconds = String(currentDateTime.getSeconds()).padStart(2, '0');
    var month = String(currentDateTime.getMonth() + 1).padStart(2, '0');

    
    var formattedDateTime_for_db_op_time = year + ':' + month + ':' + day + ' ' + hours + ':' + minutes + ':' + seconds;

    selectedDateTimeSpan.textContent = dayOfWeek + ' ' + day + 'th ' + monthName + ', ' + year + ' at ' + hours + ':' + minutes + ' ' + ampm;
    appointmentTimeInput.value = formattedDateTime_for_db_op_time;

    function updateSelectedDateTime() {
        
        var selectedValue = datetimePicker.value;
        var selectedDateTime = new Date(selectedValue);

        if (!isNaN(selectedDateTime.getTime())) {
            days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            dayOfWeek = days[selectedDateTime.getDay()];
            year = selectedDateTime.getFullYear();
            monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
            monthName = monthNames[selectedDateTime.getMonth()];
            day = selectedDateTime.getDate();
            hours = selectedDateTime.getHours();
            ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12; // Convert to 12-hour format
            minutes = String(selectedDateTime.getMinutes()).padStart(2, '0');
            seconds = String(selectedDateTime.getSeconds()).padStart(2, '0');
            month = String(selectedDateTime.getMonth() + 1).padStart(2, '0');
            
            // Update formattedDateTime_for_db_op_time based on AM/PM
            if (ampm === 'PM') {
                hours += 12;
            }
            
            formattedDateTime_for_db_op_time = year + ':' + month + ':' + day + ' ' + hours + ':' + minutes + ':' + seconds;

            selectedDateTimeSpan.textContent = dayOfWeek + ' ' + day + 'th ' + monthName + ', ' + year + ' at ' + hours + ':' + minutes + ' ' + ampm;
            appointmentTimeInput.value = formattedDateTime_for_db_op_time;
           
        datetimePicker.style.display = "none";
        }
    }

    // Function to show the datetime picker and set the default value
    function showDateTimePicker() {
     // Set the minimum selectable date and time to the current date and time
    const currentDatetimeISO = currentDateTime.toISOString().slice(0, -8);
    datetimePicker.min = currentDatetimeISO;
       //datetimePicker.min = currentDateTime;
        datetimePicker.style.display = "block";
    }
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
                 <div class="form-group">
    <label class="col-form-label">
        <span>Doctor</span>
        <span class="required-mark">*</span>
    </label>
    <div class="form-group col-sm-6">
        <select name="doctor_name" class="form-control form-control-sm" id="doctorSelector">
            <!-- Doctor options will be added dynamically using JavaScript -->
        </select>
    </div>
</div>
                    <div class="form-group">
                      <label class="col-form-label"><span>Patient Name</span><span class="required-mark">*</span></label>
                      <div class="form-group col-sm-9 appointment-form-patient-name-fields">
                       <div class="row col-sm-6 col-lg-6">
                        <div class="react-autosuggest__container" >
    
    <!-- <input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" name="patient_first_name" placeholder="First name" id="appointment-form-patient-fname" value="" onkeyup="searchPatients(this.value)">
    <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
    <div class="error-message" id="fname-error"></div>
</div>
<div class="suggestionItem" >
<select>
        
    </select>
</div>
</div> -->
<input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" name="patient_first_name" placeholder="First name" id="appointment-form-patient-fname" value="" oninput="searchPatients(this.value)">

    <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
    <div class="error-message" id="fname-error"></div>
</div>

<div class="suggestionItem">
  <select id="patientSelect" style="display: none;"></select>
  <ul id="patientList"></ul>
</div>

</div>
<script>
    
    function searchPatients(search) {
      
    const suggestionsContainer = document.getElementById('react-autowhatever-1');

    // Clear the suggestions container
    suggestionsContainer.innerHTML = '';
    const selectElement = document.getElementById('patientSelect');
const patientList = document.getElementById('patientList');



// Clear the existing options
selectElement.innerHTML = '';
patientList.innerHTML = '';

// Find the input fields by their IDs
const inputFieldFirstName = document.getElementById('appointment-form-patient-fname');
const inputFieldContactNo = document.getElementById('appointment-form-patient-contactno');
const inputFieldEmail = document.getElementById('appointment-form-patient-emailaddress');
const inputFieldLastName = document.getElementById('appointment-form-patient-lname');
const inputFieldPatientId = document.getElementById('patient_id');
const inputFieldId = document.getElementById('id');

// Reset input fields to null
// inputFieldFirstName.value = '';
    inputFieldContactNo.value = '';
    inputFieldEmail.value = '';
    inputFieldLastName.value = '';
    // inputFieldPatientId.value = '';
    inputFieldId.value = '';

    // Make an AJAX request to fetch patient details based on the user's input
    if (search.trim() !== '') {
      
        fetch(`search_drop_down_single_pateint.php?search=${search}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // If the response indicates success, populate the suggestions container
                    console.log(data);
                    const patients = data.data;
                    console.log(patients);
                    console.log(patients[0]);
                   
        // Iterate over patients using a for loop
        for (let i = 0; i < patients.length; i++) {
            const patient = patients[i];
            console.log('for loop patient details');
  
               // patientIdField.value = patient.id;
    // Clear the suggestions container
    suggestionsContainer.innerHTML = '';
    
//     const selectElement = document.getElementById('patientSelect');
// const patientList = document.getElementById('patientList');



// Clear the existing options
selectElement.innerHTML = '';
patientList.innerHTML = '';

// Create the "Select Patient" option (optional)
const defaultOption = document.createElement('option');
defaultOption.value = '';
defaultOption.textContent = 'Select Patient';
selectElement.appendChild(defaultOption);

for (let i = 0; i < patients.length; i++) {
    const patient = patients[i];
    
    // Create an option for the select element (optional)
    const option = document.createElement('option');
    option.value = patient.id;
    option.textContent = `${patient.patient_first_name}-${patient.contact_no}`;
    selectElement.appendChild(option);

    // Create a list item for the patient list
    const listItem = document.createElement('li');
    listItem.textContent = `${patient.patient_first_name}-${patient.contact_no}`;
    listItem.dataset.patientId = patient.id;
    
    // Add click event listener to the list item
    listItem.addEventListener('click', () => {
        // Handle the selection here, e.g., update input fields with the selected patient's data
        inputFieldFirstName.value = patient.patient_first_name;
        inputFieldContactNo.value = patient.contact_no;
        inputFieldEmail.value = patient.email_address;
        inputFieldLastName.value = patient.patient_last_name;
        inputFieldPatientId.value = patient.patient_id;
        inputFieldId.value = patient.id;
        
         // Check the gender radio box based on the patient's gender
    if (patient.gender === 'male') {
        document.getElementById('patient-gender-male').checked = true;
    } else if (patient.gender === 'female') {
        document.getElementById('patient-gender-female').checked = true;
    }
    
        // suggestionsContainer.innerHTML = '';
        selectElement.innerHTML = '';
        patientList.innerHTML = '';
 

    });
    
    patientList.appendChild(listItem);
}

// Show the patient list
patientList.style.display = 'block';


// Clear the suggestions container
suggestionsContainer.innerHTML = '';
        
    }
    
} else {
    // Handle case when there's an error
    console.error('Error: ' + data.message);
}
            })
            .catch(error => {
                console.error('Error fetching patient data:', error);
            });
    }
}

</script>
</div></div>
<div class="form-group">
<div class="row ">
                        <div class="react-autosuggest__container" style="width: 120px; ">
                         <input type="text"  autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" name="patient_middle_name" placeholder="Middle name" id="appointment-form-patient-mname" value="">
                         <div id="react-autowhatever-1" class="react-autosuggest__suggestions-container"></div>
                         <div class="error-message" id="mname-error"></div>
                       </div>
                       <div class="react-autosuggest__container" style="width: 120px; height: 10px;">
                         <input type="text" utocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" name="patient_last_name" placeholder="Last name" id="appointment-form-patient-lname" value="">
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
                      /* CSS styles for suggestion items */
.suggestion-item {
    border: 1px solid #ccc;
    padding: 10px;
    margin: 5px;
    cursor: pointer;
    background-color: #fff;
    transition: background-color 0.2s ease-in-out;
}

.suggestion-item:hover {
    background-color: #f0f0f0;
}

/* CSS styles for the suggestions container */
.react-autosuggest__suggestions-container {
    position: absolute;
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 2;
    max-height: 200px;
    overflow-y: auto;
}

/* CSS styles for the no results message */
.no-results-message {
    padding: 10px;
    text-align: center;
    font-style: italic;
    color: #888;
}
#event-tooltip {
  position: absolute;
  display: none;
  background-color: #fff;
  border: 1px solid #ccc;
  padding: 5px;
  z-index: 9999;
}
.hover-info {
  display: none;
  position: absolute;
  background-color: #fff;
  border: 1px solid #ccc;
  padding: 5px;
  z-index: 9999;
}


#eventDetailsModal {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1000;
}

.modal-content {
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
  border-radius: 5px;
  width: 80%;
  max-width: 500px;
  position: absolute;
  /* top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); */
  padding: 20px;
}


.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.modal-title {
  margin: 0;
  font-size: 20px;
}

.modal-body p {
  margin: 10px 0;
  font-size: 16px;
}

.modal-footer {
  text-align: right;
  margin-top: 20px;
}

.btn {
  margin-right: 10px;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
  font-weight: bold;
}

.btn.blue {
  background-color: #0074cc;
  color: #fff;
}

.btn.red {
  background-color: #ff0000;
  color: #fff;
}

.btn.yellow {
  background-color: #ffd700;
  color: #333;
}

.btn.green {
  background-color: #00cc00;
  color: #fff;
}

.btn:hover {
  opacity: 0.8;
}
.custom-btn {
  padding: 0; /* Remove padding to make the buttons compact */
  border: none; /* Remove borders */
  cursor: pointer;
  font-weight: bold;
}

.blue-text {
  color: #0074cc; /* Set the text color to blue */
}

.red-text {
  color: #ff0000; /* Set the text color to red */
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
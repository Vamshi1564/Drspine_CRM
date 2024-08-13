<!DOCTYPE html>
<?php
// if (isset($_GET['branch_name'])) {
//   // Use the provided branch name
//   $branch_name = $_GET['branch_name'];
//  } 
// else {

//   $branch_name = "Whitefield";
// }
if (isset($_GET['branch_name']) && !empty($_GET['branch_name'])) {
  // Use the provided branch name
  $branch_name = $_GET['branch_name'];
}
// else {
//   $branch_name = "Whitefield"; // Default branch name when not provided
// }
?>
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
      'description' => 'Doctor: ' . $row['doctor'] . '<br>Status: ' . $row['status']
      // 'description' => 'Doctor: ' . $row['doctor'] . '<br>Prscription: ' . $row['priscription'] . '<br>Status: ' . $row['status']
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

    /* #calendar {
      max-width: 100%;
      margin: 0 auto;
    } */
    #calendar {
      max-width: 75%;
      display: inline-block;
      vertical-align: top;
      float: left;
      flex: 1;
    }

    #calendar-right-sidebar {
      width: calc(25% - 20px);
      /* Adjust the width and padding as needed */
      display: inline-block;
      vertical-align: top;
      flex: 1;
    }


    .clear {
      clear: both;
      /* Clear the float to prevent content below from wrapping around */
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
    .error-message+.react-autosuggest__container input::placeholder {
      text-decoration: underline red;
    }

    /* Style error messages below the placeholder */
    .error-message-below {
      color: red;
      font-size: 12px;
      clear: both;
      /* Add this property to force the element to be below the input */
      display: block;
      /* Add this property to make it a block-level element */
      margin-top: 5px;
      /* Adjust the margin-top as needed */
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

  <script>
    $(document).ready(function() {
      var branchName = "<?php echo $branch_name; ?>";

      
      // alert(branchName);

      var selectedBranch = branchName;
      var selectedView = document.querySelector('input[name="view"]:checked').value;

      document.getElementById('hiddenBranch').value = '<?php echo $branch_name; ?>';

      document.getElementById('branchSelector').value = branchName;

      fetchDocotrsAPI(branchName);
      fetchAppointments(branchName); // Assuming fetchAppointments is defined elsewhere.
      fetchAndInitializeCalendar(selectedBranch, selectedView);
    });
  </script>
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
            <div class="col-sm-12">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="app_calender.php">Home</a></li>
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
                    <select class="form-control" name="branchSelector" id="branchSelector" onchange="updateBranchSession()">
                      <option value="whitefield" <?php echo ($branch_name === 'whitefield') ? 'selected' : ''; ?>>WhiteField</option>
                      <option value="BEL Road" <?php echo ($branch_name === 'BEL Road') ? 'selected' : ''; ?>>BEL Road</option>
                      <option value="Indira Nagar" <?php echo ($branch_name === 'Indira Nagar') ? 'selected' : ''; ?>>Indira Nagar</option>
                    </select>

                    <br>
                    <input type="radio" name="view" value="today" style="display: none;" checked>
                    <!-- <input type="radio" name="view" value="4days"> 4 Days -->
                    <input type="radio" name="view" value="weekly" style="display: none;">
                    <input type="radio" name="view" value="monthly" style="display: none;">
                  </div>
                </div>


                <script>
                  var calendar;


                  function fetchAndInitializeCalendar(branchName, view) {
                    var viewOption;
                    if (view === 'today') {
                      // Set the view to 'agendaDay' for Today
                      viewOption = 'agendaDay';

                    } else if (view === 'weekly') {
                      // Set the view to 'agendaWeek' for Weekly
                      viewOption = 'agendaWeek';
                    } else if (view === 'monthly') {
                      // Set the view to 'month' for Monthly
                      viewOption = 'month';
                    }

                    //   if (view === '4days') {
                    //     // Set the view's duration to 4 days
                    //     calendar.fullCalendar('option', 'duration', { days: 4 });
                    //   }

                    $.ajax({
                      url: 'getAPI_appointment_details.php',
                      type: 'GET',
                      data: {
                        branch_name: branchName
                      },
                      success: function(data) {
                        // Assuming your API returns an array of appointment objects
                        var eventsData = data.map(function(appointment) {
                          // Map your appointment data to FullCalendar events format
                          // var title = `${appointment.patient_first_name} ${appointment.patient_last_name}-${appointment.patient_id}- (ID: ${appointment.id}) - Dr. ${appointment.doctor_name}`;

                          // if (appointment.cancelled_by) {
                          //   title += ` - ${appointment.cancelled_by}`;
                          // // title = `<span class="cancelled-appointment">${title} - ${appointment.cancelled_by}</span>`;

                          // }
                          var title = `${appointment.patient_first_name} ${appointment.patient_last_name}-${appointment.patient_id}- (ID: ${appointment.id}) - Dr. ${appointment.doctor_name}`;

                          if (appointment.cancelled_by) {
                            // title = `<del style="color: red">${title} - ${appointment.cancelled_by}</del>`;
                            title = `<span style="text-decoration: line-through; color: red; background-color: white;">${title} - ${appointment.cancelled_by}</span>`;

                          }
                          // alert(appointment.cancelled_by);
                          // alert(appointment.no_of_booked_appointments_patient_id);
                          if (appointment.no_of_booked_appointments_patient_id < 2) {
                            // title = `<del style="color: red">${title} - ${appointment.cancelled_by}</del>`;
                            title = `<span style="color: black;">${title}</span>`;

                          }




                          return {
                            id: appointment.id,
                            title: title,
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
                          eventRender: function(event, element) {
                            element.find('.fc-title').html(event.title); // Enable HTML rendering for the title
                          },
                          defaultView: viewOption,
                          events: eventsData,
                          customButtons: {
                            view4Days: {
                              text: 'today',
                              click: function() {
                                // Change the view to 'agendaWeek' with 4 days
                                calendar.fullCalendar('changeView', 'agendaDay', {
                                  duration: {
                                    days: 1
                                  }
                                });
                              }
                            }
                          },
                          header: {
                            left: 'prev,today,next',
                            center: 'title',
                            right: 'view4Days,agendaWeek,month,next'
                          },
                          slotDuration: '00:10:00', // Set your default slot duration here
                          minTime: '08:00:00',
                          maxTime: '22:00:00',
                          editable: true, // Enable event dragging and resizing
                          eventDurationEditable: true, // Allow event duration to be editable
                          events: eventsData, // Use the mapped data



                          eventDragStart: function(event, jsEvent, ui, view) {
                            // This function is called when an event dragging operation starts
                            // You can capture the original duration_minutes value here if needed
                            event.originalDurationMinutes = event.duration_minutes;
                          },

                          eventDragStop: function(event, jsEvent, ui, view) {
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
                              success: function(response) {
                                fetchAppointments(branchName);
                                console.log('eventdragfunction Duration minutes updated successfully:', response.message);
                              },
                              error: function() {
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
                              success: function(response) {
                                console.log('Duration minutes updated successfully:', response.message);
                              },
                              error: function() {
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
                                newEndTime: newEndTime.format() // Send the updated end time
                              },
                              success: function(response) {
                                console.log('Appointment time updated successfully:', response.message);
                                if (response.success) {
                                  fetchAppointments(branchName);
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
                  // document.getElementById("branchSelector").addEventListener("change", function() {

                  //   var selectedBranch = this.value;
                  //   var selectedView = document.querySelector('input[name="view"]:checked').value;

                  //   const branchSelector = document.getElementById('branchSelector');
                  //   const doctorSelector = document.getElementById('doctorSelector');

                  //   fetchDocotrsAPI(selectedBranch);
                  //   fetchAppointments(selectedBranch);
                  //   fetchAndInitializeCalendar(selectedBranch, selectedView);

                  //   var newUrl = "app_calender.php?branch_name=" + selectedBranch;

                  //   // Redirect to the new URL to trigger the page refresh
                  //   window.location.href = newUrl;


                  // });

                  // Attach an event listener to the view selector
                  document.getElementsByName("view").forEach(function(radio) {
                    radio.addEventListener("change", function() {
                      var selectedBranch = document.getElementById("branchSelector").value;
                      var selectedView = this.value;

                      fetchAndInitializeCalendar(selectedBranch, selectedView);
                    });
                  });

                  // Initial load of the calendar for today's events and 'agendaWeek' view
                  var initialBranch = document.getElementById("branchSelector").value;
                  var initialView = document.querySelector('input[name="view"]:checked').value;
                  fetchAndInitializeCalendar(initialBranch, initialView);

                  function fetchDocotrsAPI(selectedBranch) {
                    // alert(selectedBranch);
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


                <style>
                  /* Styling for the modal */
                  .patient-details-modal {
                    background-color: #fff;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                    border-radius: 5px;
                    width: 100%;
                    max-width: 500px;
                    position: absolute;
                    top: 4%;
                    left: 100%;
                    transform: translate(+30%, +70%);
                    padding: 20px;
                  }

                  /* Styling for buttons and button-row */
                  .button-row {
                    display: flex;
                    justify-content: space-between;
                    margin-top: 10px;
                  }

                  .btn {
                    padding: 10px 20px;
                    margin-right: 10px;
                    border: none;
                    cursor: pointer;
                  }

                  .custom-btn {
                    padding: 5px 10px;
                    border: none;
                    cursor: pointer;
                    border-radius: 5px;
                  }
                </style>
                <!-- form start -->
                <div class="card-body">
                  <div id="calendar"></div>
                  <div id="calendar-right-sidebar" class="calendar-right-sidebar">
                    <div>
                      <div class="calendar-right-side-header">
                        <span class="header-title">Today's Schedule</span>
                      </div>
                      <div class="appointment-state-wrapper">
                        <div class="appointment-state state-schedule">
                          <div class="appointment-state-number-wrapper"><span id="schedule-count">0</span></div>
                          <div class="appointment-state-detail-wrapper"><span>Schedule</span></div>
                        </div>
                        <div class="appointment-state state-waiting">
                          <div class="appointment-state-number-wrapper"><span id="waiting-count">0</span></div>
                          <div class="appointment-state-detail-wrapper"><span>Waiting</span></div>
                        </div>
                        <div class="appointment-state state-engage">
                          <div class="appointment-state-number-wrapper"><span id="engage-count">0</span></div>
                          <div class="appointment-state-detail-wrapper"><span>Engage</span></div>
                        </div>
                        <div class="appointment-state state-checkout inactive">
                          <div class="appointment-state-number-wrapper"><span id="done-count">0</span></div>
                          <div class="appointment-state-detail-wrapper"><span>Done</span></div>
                        </div>
                      </div>

                      <div class="today-appointment-list _webkit_scroll_bar" style="max-height: 380px; overflow-y: scroll;">
                        <div class="appointment-list-item">
                          <!-- Today's appointments will be populated here -->
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="clear"></div>


                  <script>
                    var appointmentStateWrapper = document.querySelector('.appointment-state-wrapper');
                    var todayAppointmentList = document.querySelector('.today-appointment-list');

                    function fetchAppointments(branchName) {
                      // appointmentStateWrapper.innerHTML= '';

                      // Empty the content of the todayAppointmentList
                      todayAppointmentList.innerHTML = '';
                      $.ajax({
                        url: 'getAPI_today_appointment_details.php', // Replace with the correct API endpoint
                        type: 'GET',
                        data: {
                          branch_name: branchName
                        }, // Pass the branch name as a parameter
                        dataType: 'json',
                        success: function(data) {
                          displayAppointments(data.results);
                          // Update the appointment count
                          //document.getElementById('appointment-count').textContent = data.count;
                          // Update the counts in the HTML
                          $('#schedule-count').text(data.scheduleCount);
                          $('#waiting-count').text(data.waitingCount);
                          $('#engage-count').text(data.engageCount);
                          $('#done-count').text(data.doneCount);
                        },
                        error: function(xhr, status, error) {
                          console.error('Error fetching data:', status, error);
                        }
                      });
                    }

                    function displayAppointments(data) {


                      data.forEach(function(appointment) {
                        // Create appointment states
                        //   var appointmentState = document.createElement('div');
                        //   appointmentState.classList.add('appointment-state');
                        //   // Add data to appointment states here
                        //   appointmentState.innerHTML = `

                        //     <div class="appointment-state-detail-wrapper"><span>${appointment.branch_name}</span></div>
                        //   `;
                        //   appointmentStateWrapper.appendChild(appointmentState);

                        // Create appointment list items
                        var appointmentListItem = document.createElement('div');
                        appointmentListItem.classList.add('appointment-list-item');
                        // Add data to appointment list items here
                        function formatAppointmentTime(dateTimeString) {
                          const date = new Date(dateTimeString);
                          const hours = date.getHours().toString().padStart(2, '0');
                          const minutes = date.getMinutes().toString().padStart(2, '0');
                          return `${hours}:${minutes}`;
                        }
                        // Determine the initial status text based on the appointment's status
                        var initialStatusText = '';
                        switch (appointment.status) {
                          case 'schedule':
                            initialStatusText = 'Scheduled';
                            break;
                          case 'waiting':
                            initialStatusText = 'Waiting';
                            break;
                          case 'engage':
                            initialStatusText = 'Engage';
                            break;
                          case 'done':
                            initialStatusText = 'Done';
                            break;
                            // Add more cases if needed for other status values
                        }


                        appointmentListItem.innerHTML = `
  <span class="tip"></span>
  <div class="appointment-list-item-wrapper">
    <div class="appointment-list-item-left">
      <div class="doctor-details-dot" style="background: rgb(126, 198, 88);"></div>
      <div class="patient-name-time-wrapper">
        <div class="appointment-state-number-wrapper"><span id="rightsidebar_popup_id" hidden>${appointment.id}</span></div>
        <div class="patient-name-wrapper">
          <span class="patient-name">${appointment.patient_first_name} ${appointment.patient_last_name}</span>
        </div>
        <div class="patient-time-wrapper" style="margin-top: 5px;">
          <span class="appointment-time">${formatAppointmentTime(appointment.appointment_date_time)}</span>
        </div>
        <!-- Add other appointment details -->
        <div class="appointment-list-item-extra">
          <div class="status-button">
            <span id="right_side_bar_scheduled" class="state-info status-text status-schedule${appointment.today_status === 'scheduled' ? ' active' : ''}">${appointment.today_status}</span>
            <span class="state-info status-text status-waiting${appointment.today_status === 'waiting' ? ' active' : ''}">Waiting</span>
            <span class="state-info status-text status-engage${appointment.today_status === 'engage' ? ' active' : ''}">Engage</span>
            <span class="state-info status-text status-done${appointment.today_status === 'done' ? ' active' : ''}">Done</span>
          </div>
          <div class="status-loading hidden"><span class="state-info">Loading..</span></div>
          <span class="material-icons" data-toggle="tooltip" data-placement="bottom" title="Ask for Review">star_half</span>
        </div>
      </div>
    </div>
  </div>
`;

                        todayAppointmentList.appendChild(appointmentListItem);
                      });
                    }
                    $(document).ready(function() {
                      // Hover over the patient details wrapper
                      $(document).on('click', '.patient-name-time-wrapper', function() {
                        // Find the hidden ID span within this wrapper

                        var rightsidebar_popup_id = $(this).find('#rightsidebar_popup_id').text();
                        console.log("on clicked patient-name-time-wrapper", rightsidebar_popup_id);
                        // alert("on clicked patient-name-time-wrapper, ID: " + rightsidebar_popup_id);
                        get_patientdetails_with_id(rightsidebar_popup_id);
                      });

                      // Hide the modal when the close button is clicked
                      $('#eventDetailsModal #closeModalBtn').click(function() {
                        $('#eventDetailsModal').hide();
                      });
                    });
                  </script>


                  <div id="eventDetailsModal" class="modal">
                    <div class="modal-content">
                      <div id="patient_details_modal" class="patient-details-modal">
                        <div style="position: relative;">
                          <button class="btn" id="closeModalBtn"><span style="position: absolute; top: 5px; right: 5px; cursor: pointer; font-size: 24px;">&times;</span></button>
                        </div>
                        <input type="hidden" name="popup_id" id="popup_id">
                        <input type="hidden" name="eventdetailsmodal_branch_name" id="eventdetailsmodal_branch_name">

                        <p style="color: blue" id="patientFirstName"></p>

                        <div id="statusDropdown">
                          <select id="appointmentStatus">
                            <!-- <option value="" style="display:none;">Select</option> -->
                            <option value="schedule">Schedule</option>
                            <option value="waiting">Waiting</option>
                            <option value="engage">Engage</option>
                            <option value="done">Done</option>
                          </select>
                        </div>

                        <p id="contactNumber"></p>
                        <p id="on_hover_gender"></p>

                        <div class="row">
                          <div class="col-md-6">
                            <p id="doctorName"></p>
                          </div>
                          <div class="col-md-6">
                            <button class="custom-btn blue-text" id="editButton">Edit</button>
                            <button class="custom-btn red-text">Delete</button>
                          </div>
                        </div>
                        <p id="appointmentTime"></p><span id="span_eventdetailsmodal_duration"></span>
                        <input type="hidden" name="onhover_appointment_date_time" id="onhover_appointment_date_time">
                        <input type="hidden" id="eventdetailsmodal_duration" name="eventdetailsmodal_duration">
                        <div class="modal-footer">
                          <div class="button-row">
                            <button class="btn red" id="cancelBtn">Cancel</button>
                            <button class="btn yellow hidden" id="missedBtn">Missed</button>
                            <button class="btn blue hidden" id="followupBtn">Follow</button>
                            <button class="btn green hidden" id="paymentBtn">Payment</button>

                          </div>

                        </div>
                      </div>
                    </div>
                  </div>


                  <!-- cancelapointmetmodal start-->
                  <div id="cancelAppointmentModal" class="modal fade show" role="dialog" tabindex="-1" style="display: none;">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Cancel Appointment</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <div aria-hidden="true" class="modal-close-button">×</div>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div>
                            <div class="kivimodal-content cancel-appointment-modal-content">
                              <form class="form-horizontal">
                                <div class="form-group">
                                  <label class="col-form-label">Cancel By</label>
                                  <input type="hidden" id="cancelled_by_id" name="cancelled_by_id">
                                  <div class="form-check form-check-inline">
                                    <input id="cancelby-doctor" name="cancel-by" class="form-check-input" type="checkbox" value="cancelled_by_doctor" checked>
                                    <label class="form-check-label" for="cancelby-doctor">Doctor</label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input id="cancelby-patient" name="cancel-by" class="form-check-input" type="checkbox" value="cancelled_by_patient">
                                    <label class="form-check-label" for="cancelby-patient">Patient</label>
                                  </div>


                                </div>

                                <script>
                                  function showAlert(value) {
                                    //    alert("Selected value: " + value);
                                  }
                                </script>

                                <div class="form-group">
                                  <label class="col-form-label">Send SMS</label>
                                  <div class="form-group col-sm-5">
                                    <div class="form-check form-check-inline">
                                      <input name="cancel-by" id="cancel-appointment-notify-doctor" class="form-check-input" type="checkbox" value="doctor">
                                      <label class="form-check-label" for="cancel-appointment-notify-doctor">Doctor</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input name="cancel-by" id="cancel-appointment-notify-patient" class="form-check-input" type="checkbox" value="patient">
                                      <label class="form-check-label" for="cancel-appointment-notify-patient">Patient</label>
                                    </div>


                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-form-label">Reason</label>
                                  <div class="form-group col-sm-8">
                                    <textarea name="reason-for-cancel" class="form-control" rows="5" placeholder="Reason for cancellation"></textarea>
                                  </div>
                                </div>
                                <div class="kivimodal-footer">
                                  <button id="cancelAppointmentButton" class="btn btn-sm btn-success btn-blue">Cancel Appointment</button>

                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--cancelapointmetmodal end -->

                  <script>
                    $(document).ready(function() {
                      $("#cancelAppointmentButton").click(function() {

                        var cancelled_by_id = document.getElementById("cancelled_by_id").value;
                        var cancelledBy = $('[name="cancel-by"]:checked').val();
                        var reasonForCancel = $("textarea[name='reason-for-cancel']").val();
                        // alert("reasonForCancel: " + reasonForCancel);
                        // alert(cancelledBy);

                        var cancel_branchName = document.getElementById("eventdetailsmodal_branch_name").value;
                        // alert(cancel_branchName);

                        $.ajax({
                            type: 'POST',
                            url: 'update_cancel_appointment_status.php',
                            data: {
                              branch_name: cancel_branchName,
                              id: cancelled_by_id,
                              cancelled_by: cancelledBy,
                              reason_for_cancel: reasonForCancel
                            },
                            error: function(xhr, status, error) {
                              console.error(error);
                              alert('Error: ' + error);
                            }
                          })
                          .done(function(response) {
                            console.log('Before response success checking from the API:', response);
                            // alert("Before response success");
                            if (response.success) {
                              console.log('Received data from the API:', response);
                              alert("Appointment cancelled successfully");
                              window.location.href = "app_calender.php?branch_name=" + cancel_branchName;
                            } else {
                              alert("Error: " + response.error);
                            }
                          });



                      });

                    });
                  </script>

                  <!--followupapointmetmodal start -->
                  <div class="appointment-edit-wrapper" id="followupappointmentmodal" style="display:none">
                    <form class="">
                      <div class="form-group">
                        <label class="col-form-label">Doctor</label>
                        <div class="form-group col-sm-12">
                          <select class="form-control form-control-sm">
                            <option value="32157">Dr. Jay</option>
                            <option value="35276">Pruthvi</option>
                            <option value="35274">Gowri Raju</option>
                            <option value="35275">Puneeth</option>
                            <option value="35338">Dr. Philip Reed</option>
                            <option value="35339">Dr. John Clark</option>
                            <option value="39782">Dr. Kavya Prashanth</option>
                            <option value="42546">Dr. James M</option>
                            <option value="42648" selected="">Dr. TROY SCHIEBLE</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-form-label">Date &amp; Time</label>
                        <div class="edit-date-time-wrapper">
                          <div class="form-group col-sm-6">
                            <input type="text" class="form-control hasDatepicker" placeholder="Appointment Date" value="16-10-2023" id="dp1697375213775">
                          </div>
                          <div class="form-group col-sm-2">
                            <select class="form-control form-control-sm selected-duration">
                              <option value="HH">HH</option>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                              <option value="10" selected="">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                            </select>
                          </div>
                          <div class="form-group col-sm-2">
                            <select class="form-control form-control-sm selected-duration">
                              <option value="MM">MM</option>
                              <option value="0">00</option>
                              <option value="5">5</option>
                              <option value="10">10</option>
                              <option value="15">15</option>
                              <option value="20">20</option>
                              <option value="25">25</option>
                              <option value="30">30</option>
                              <option value="35">35</option>
                              <option value="40">40</option>
                              <option value="45" selected="">45</option>
                              <option value="50">50</option>
                              <option value="55">55</option>
                            </select>
                          </div>
                          <div class="form-group col-sm-2">
                            <select class="form-control form-control-sm selected-duration">
                              <option value="am" selected="">AM</option>
                              <option value="pm">PM</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="edit-date-time-wrapper">
                          <div class="form-group col-sm-6 vertical-label-formgroup">
                            <label class="col-form-label">Duration</label>
                            <select class="form-control form-control-sm selected-duration">
                              <option value="5" selected="">05 Minutes</option>
                              <option value="10">10 Minutes</option>
                              <option value="15">15 Minutes</option>
                              <option value="30">30 Minutes</option>
                              <option value="45">45 Minutes</option>
                              <option value="60">1 Hour</option>
                              <option value="90">1 Hours 30 Minutes</option>
                              <option value="120">2 Hours</option>
                              <option value="150">2 Hours 30 Minutes</option>
                              <option value="180">3 Hours</option>
                              <option value="360">6 Hours</option>
                              <option value="1440">Full Day</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-form-label">Reason</label>
                        <div class="form-group col-sm-12">
                          <textarea class="form-control" rows="1" placeholder="Reason for appointment"></textarea>
                        </div>
                      </div>
                      <div class="form-group book-multiple-wrapper">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox" id="book-multiple-appointment" value="yes">
                          <label class="form-check-label" for="book-multiple-appointment">Book Multiple</label>
                        </div>
                      </div>
                      <div class="edit-appointment-popover-footer">
                        <div class="button-wrapper">
                          <div class="button-save"><span>Save</span></div>
                          <div class="button-cancel" onclick="closeFollowupModal()"><span>Cancel</span></div>
                        </div>
                        <div class="loader"></div>
                      </div>
                    </form>
                  </div>
                  <!--followupapointmetmodal end -->




                  <div id="request-payment-modal" class="modal show" tabindex="-1" role="dialog" style="display: none; padding-right: 19px;">
                    <div class="modal-dialog" role="document" style="min-width:700px !important">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title">Request Payment Online</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <div aria-hidden="true" class="modal-close-button">×</div>
                          </button>
                        </div>
                        <div class="modal-body">
                          <style>
                            #request-payment-modal input[type=checkbox] {
                              margin-top: -2px;
                              font-size: 14px;
                            }

                            #request-payment-modal tr>th,
                            #request-payment-modal td {
                              font-size: 12px !important;
                              font-family: 'SF UI Text Regular' !important;
                              font-weight: 400 !important;
                            }
                          </style>
                          <div class="row" style="margin:0px">
                            <div class="col-xs-12">
                              <div style="margin-bottom:5px">
                                <span style="font-family: 'SF UI Text Medium';font-size:14px">Please enter the amount you want to request.</span>
                              </div>
                              <div>
                                <span style="font-size:13px">An SMS with URL will be sent to patient for making payment of the entered amount.</span>
                              </div>
                            </div> <!-- ending of col -->

                            <!-- Button and text field start -->

                            <div style="margin-top:20px;display:flex;width:100%">
                              <input type="text" id="paymentInputPlanW" class="form-control input-sm paymentInput numberInputOnly" placeholder="Enter amount" style="width:200px">
                              <input type="submit" class="btn btn-sm btn-success btn-blue requestPaymentAddBtn" data-patientid="30075832" value="Request">
                            </div>

                            <div style="display: flex;width: 100%;margin-top:20px;font-size:13px">

                              <div style="display: flex;align-items: center;margin-right: 10px;">
                                <input type="checkbox" name="requestonesms" id="requestonesms" value="" checked="checked">
                                <label for="requestonesms" class="cursorPoint" style="font-size:13px;margin-bottom:0px;margin-left:5px;margin-right:10px">Send SMS</label>
                                <input type="checkbox" name="requestonemail" id="requestonemail" value="">
                                <label for="requestonemail" class="cursorPoint" style="font-size:13px;margin-bottom:0px;margin-left:5px">Send Email</label>
                              </div><!-- ending of col -->

                              <div style="align-items: center;width: 60%;justify-content: flex-end;">
                                <input type="checkbox" name="openinbrowser" id="openinbrowser" style="margin-right: 5px;">
                                <label for="openinbrowser" style="margin-bottom:0;font-size: 13px;" class="cursorPoint">Patient doesn't have smartphone</label>
                              </div>
                            </div>



                            <div style="margin-top:5px;width:100%;margin-top: 20px;align-items: center;margin-bottom:10px">
                              <div data-intro="Tick the checkbox to add the convenience fee to the patient bill.Leave the checkbox blank to bear the same.">
                                <input type="checkbox" name="takewalletfeesfrompatient" id="takewalletfeesfrompatient">
                                <label for="takewalletfeesfrompatient" style="font-size:13px">Take convenience fees from patient</label>
                              </div>
                            </div><!-- ending of col -->


                            <div style="width: 100%;display: flex;">
                              <div class="col-xs-12 col-sm-6" id="requestPaymentBrkup" style="padding-left:0px;display:none;padding-right:15px">
                                <table class="table table-bordered">
                                  <tbody>
                                    <tr>
                                      <th>Transaction fees</th>
                                      <td width="90">10</td>
                                    </tr>
                                    <tr>
                                      <th>Card fees</th>
                                      <td width="90">2%</td>
                                    </tr>
                                    <tr>
                                      <th>GST on card fees</th>
                                      <td width="90">18%</td>
                                    </tr>
                                    <tr>
                                      <th>Transfer fees</th>
                                      <td width="90">0.25%</td>
                                    </tr>
                                    <tr style="background:#f7f7f7;">
                                      <th>Final amount</th>
                                      <td width="90">
                                        <label name="finalamtval" style="font-weight: bold; margin-bottom:0;" id="finalamtval">0</label>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table><!-- ending of table -->
                              </div><!-- ending of col12 -->

                              <div class="col-xs-12 col-sm-6" style="padding:0px">
                                <table class="table table-bordered">
                                  <tbody>
                                    <tr>
                                      <td>Indian debit cards</td>
                                      <td>2%</td>
                                    </tr>
                                    <tr>
                                      <td>Netbanking &amp; Wallets</td>
                                      <td>2%</td>
                                    </tr>
                                    <tr>
                                      <td>Credit cards</td>
                                      <td>2%</td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div><!-- ending of col -->
                            </div>

                            <div class="col-xs-12" style="margin: 10px 0px;">
                              <span class="text-warning" style="font-size: 13px;">*This payment will be added as an advance payment.</span>
                            </div><!-- ending of col -->

                            <div class="alert alert-info" role="alert" style="padding: 10px;">
                              <span style="font-size: 11px;">Go Paperless - Don't let cash-crunch affect your business. Go cashless with KiViHealth's Digital Solution. When you click Request, an SMS will be sent to the patient with the amount of money to be collected and link from where to pay. Once the patient does the transaction you will be informed about the successful transaction. The money will be credited to your account in 3-4 days.</span>
                            </div>

                          </div><!-- ending of row -->


                          <script>
                            var currenttreatmentTotalCk = 0
                            $('.invoicecheckbox').on('change', function(e) {
                              var amountdue = $(this).data('amountdue')
                              if ($(this).is(":checked")) {
                                currenttreatmentTotalCk += parseFloat(amountdue)
                              } else {
                                currenttreatmentTotalCk -= parseFloat(amountdue)
                              }
                              var currentCredits = 0
                              if ($('#credits').size() > 0 && $('#credits').is(":checked")) {
                                currentCredits = $('#credits').data('amountcredit')
                              }
                              if (currenttreatmentTotalCk != 0) {
                                var remainToShow = 0
                                if (currentCredits < currenttreatmentTotalCk) {
                                  remainToShow = currenttreatmentTotalCk - currentCredits
                                }
                                remainToShow = remainToShow.toFixed(2)
                                $('.paymentInput').removeAttr('readonly')
                                $('.paymentInput').val(remainToShow)
                              } else {
                                $('.paymentInput').removeAttr('readonly')
                                $('.paymentInput').val(0)
                              }
                              recountFinalRequestAmount()
                            })

                            $('#takewalletfeesfrompatient').on('change', function(e) {
                              if ($(this).is(":checked")) {
                                $('#requestPaymentBrkup').show()
                              } else {
                                $('#requestPaymentBrkup').hide()
                              }
                            });

                            $('#paymentInputPlanW').on("change paste keyup", function() {
                              recountFinalRequestAmount();
                            });

                            function recountFinalRequestAmount() {
                              var amountval = $('#paymentInputPlanW').val()
                              if (amountval == '') {
                                amountval = 0
                              } else {
                                amountval = parseInt(amountval)
                              }
                              if (amountval == 0) {
                                $('#finalamtval').text('0')
                              }
                              $('#finalamtval').text(getFinalRequestedAmountAfterFees(amountval))
                            }

                            function getFinalRequestedAmountAfterFees(amountval) {

                              var servicetax = payment_servicetax
                              var transacationCharge = wallet_fees
                              var kivihealthcharges = kivihealth_fees
                              var transferfees = transfer_fees

                              var walletFeesChargeMultiplier = transacationCharge / 100
                              var serviceTaxMultiplier = servicetax / 100
                              var transferFeesChargeMultiplier = transferfees / 100

                              var cardfees = getCardfees(amountval, walletFeesChargeMultiplier, serviceTaxMultiplier)

                              var amountafterdeductcardfees = amountval - cardfees

                              var routefees = getRoutefess(amountafterdeductcardfees, transferFeesChargeMultiplier, serviceTaxMultiplier)

                              var totalfeesofAmount = cardfees + routefees

                              /* Calculation for Transfer fees Cost */
                              var part1 = totalfeesofAmount * walletFeesChargeMultiplier
                              var part2 = totalfeesofAmount * walletFeesChargeMultiplier * serviceTaxMultiplier
                              var part3 = totalfeesofAmount * transferFeesChargeMultiplier
                              var part4 = totalfeesofAmount * transferFeesChargeMultiplier * serviceTaxMultiplier

                              var totalcostoftransferFess = part1 + part2 + part3 + part4

                              var amountval = (amountval + totalfeesofAmount + totalcostoftransferFess + 10).toFixed(2)

                              return amountval
                            }

                            function getCardfees(amountval, walletFeesChargeMultiplier, serviceTaxMultiplier) {
                              var cardfees1 = amountval * walletFeesChargeMultiplier
                              var cardfees2 = cardfees1 * serviceTaxMultiplier
                              return cardfees1 + cardfees2
                            }

                            function getRoutefess(amountafterdeductcardfees, transferFeesChargeMultiplier, serviceTaxMultiplier) {
                              var routefees1 = amountafterdeductcardfees * transferFeesChargeMultiplier
                              var routefees2 = routefees1 * serviceTaxMultiplier
                              return routefees1 + routefees2
                            }

                            $('.requestPaymentAddBtn').on('click', function(e) {
                              e.preventDefault()
                              var amount = $('.paymentInput').val().trim()
                              if (amount == '') {
                                $('.paymentInput').focus()
                                alert('Please Enter Amount')
                                return
                              }
                              var nonChecked = true;
                              var checkedInvoices = [];

                              if ($('.invoicecheckbox').size() > 0) {
                                $('.invoicecheckbox').each(function(index) {
                                  if ($(this).is(":checked")) {
                                    nonChecked = false;
                                    checkedInvoices.push($(this).val());
                                  }
                                });
                                if (nonChecked) {
                                  alert('Please select atleast one treatment plan')
                                  return;
                                }
                              }
                              var payment = {};
                              payment.patientid = $(this).attr("data-patientid");
                              payment.amount = amount;
                              payment.invoices = checkedInvoices;
                              payment.takewalletfeesfrompatient = $("#takewalletfeesfrompatient").is(":checked")
                              payment.requestonesms = $("#requestonesms").is(":checked")
                              payment.requestonemail = $("#requestonemail").is(":checked")
                              payment.openinbrowser = $("#openinbrowser").is(":checked")
                              payment.onlinepaymentservicetax = 15

                              var button = $(this)

                              if (!payment.requestonesms && !payment.requestonemail) {
                                alert('Please select atleast one metod to request payment.')
                                return
                              }

                              $.ajax({
                                type: 'POST',
                                url: '/doctor/check-finance-detail',
                                beforeSend: function() {
                                  button.attr('disabled', 'disabled')
                                  button.val('Adding Payment')
                                },
                                success: function(data) {
                                  if (data.status == 1) {
                                    $.ajax({
                                      type: 'POST',
                                      url: Routing.generate('doctor_add_requestedpayment'),
                                      data: {
                                        'payment': payment
                                      },
                                      success: function(data) {
                                        button.removeAttr('disabled')
                                        button.val('Request')
                                        $('#request-payment-modal').modal('hide')
                                        if (data.status == 1) {
                                          alert(data.message)
                                          if (payment.openinbrowser && typeof data.paymenturl !== "undefined") {
                                            var win = window.open(data.paymenturl, '_blank')
                                            win.focus()
                                          }
                                        } else {
                                          alert(data.message)
                                        }
                                      },
                                      error: function(e, textStatus) {
                                        alert('Error occured while requesting payment, Please try again!')
                                        button.removeAttr('disabled')
                                        button.val('Request')
                                        $('#request-payment-modal').modal('hide')
                                      }
                                    });
                                  } else {
                                    alert(data.message)
                                    button.removeAttr('disabled')
                                    button.val('Request')
                                  }
                                },
                                error: function(e, textStatus) {
                                  alert('Error occured while requesting payment, Please try again!')
                                  button.removeAttr('disabled')
                                  button.val('Request')
                                  $('#request-payment-modal').modal('hide')
                                }
                              });
                            });
                          </script>
                        </div>
                      </div>
                    </div>
                  </div>
                  <script>
                    document.getElementById("paymentBtn").addEventListener("click", function() {

                      $('#request-payment-modal').modal('show');
                    });

                    document.getElementById("followupBtn").addEventListener("click", function() {

                      $('#followupappointmentmodal').modal('show');
                    });


                    function closeFollowupModal() {
                      var modal = document.getElementById("followupappointmentmodal");
                      modal.style.display = "none";
                    }



                    // Update the status in the database when a status is selected
                    document.getElementById("appointmentStatus").addEventListener("change", function() {
                      var appointmentId = document.getElementById("popup_id").value; // Replace with the actual appointment ID
                      var newStatus = this.value;
                      var branchName = document.getElementById("eventdetailsmodal_branch_name").value;

                      //alert (newStatus);

                      // Send an AJAX request to update the status
                      $.ajax({
                        url: 'update_sidebar_status.php', // Replace with the actual URL
                        type: 'POST',
                        data: {
                          id: appointmentId,
                          status: newStatus
                        },
                        success: function(data) {
                          console.log("Status updated successfully");
                          alert("Status updated successfully");

                          // window.location.href = window.location.href;
                          fetchAppointments(branchName);
                        },
                        error: function(error) {
                          console.error('Error updating status:', error);
                        }
                      });
                    });

                    // Hide the status dropdown on scroll
                    window.addEventListener("scroll", function() {
                      document.getElementById("statusDropdown").style.display = "none";
                    });
                  </script>

                  <script>
                    // Update the status in the database when a status is selected
                    document.getElementById("missedBtn").addEventListener("click", function() {
                      updateStatus("missed");
                    });

                    // document.getElementById("cancelBtn").addEventListener("click", function () {
                    //   updateStatus("canceled");
                    // });
                    document.addEventListener('DOMContentLoaded', function() {
                      // Get a reference to the modal
                      var modal = document.getElementById("cancelAppointmentModal");

                      var cancelBtn = document.getElementById("cancelBtn");
                      var popupIdInput = document.getElementById("popup_id");
                      var cancelledByIdInput = document.getElementById("cancelled_by_id"); // Get the input field
                      // var cancelpopupmodalbranchname
                      cancelBtn.addEventListener("click", function() {
                        var cancelled_by_id = popupIdInput.value; // Get the value from popup_id input
                        console.log("Cancelled By ID: " + cancelled_by_id);

                        // Assign the value to cancelled_by_id input field
                        cancelledByIdInput.value = cancelled_by_id;

                        modal.style.display = "block";
                      });

                      // Function to close the modal
                      function closeModal() {
                        modal.style.display = "none";
                      }

                      // Close the modal when the close button is clicked
                      document.querySelector(".modal-close-button").addEventListener("click", closeModal);

                      // Close the modal when clicking outside the modal content
                      window.addEventListener("click", function(event) {
                        if (event.target == modal) {
                          closeModal();
                        }
                      });
                    });

                    function updateStatus(newStatus) {
                      var appointmentId = document.getElementById("popup_id").value; // Replace with the actual appointment ID

                      // Send an AJAX request to update the status
                      $.ajax({
                        url: 'update_appointment_status.php', // Replace with the actual URL
                        type: 'POST',
                        data: {
                          id: appointmentId,
                          status: newStatus
                        },
                        success: function(data) {
                          console.log("Status updated successfully");
                          alert("Status updated successfully");

                        },
                        error: function(error) {
                          console.error('Error updating status:', error);
                        }
                      });
                    }
                  </script>
                </div>

                <!-- Popup Modal Ends -->
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    console.log("DOM is ready"); // Log a message to confirm that the event listener is active

                    // Add an event listener to the "Save" button
                    document.getElementById("saveEditBtn").addEventListener("click", function() {
                      // Get values from form elements
                      const patient_edit_id = document.getElementById("patient_edit_id").value;
                      const editDoctorName = document.getElementById("editDoctorName").value;
                      const editeventmodal_appointment_date_time = document.getElementById("editeventmodal_appointment_date_time").value;
                      const editeventmodal_duration_select = document.getElementById("editeventmodal_duration_select").value;
                      const editReason = document.getElementById("editReason").value;

                      console.log("patient_edit_id: " + patient_edit_id); // Log the value
                      // alert(patient_edit_id);

                      var edit_branchName = document.getElementById("eventdetailsmodal_branch_name").value;
                      // alert(edit_branchName);

                      // Make an AJAX request to update the appointment
                      $.ajax({
                        type: "POST", // Use POST or GET based on your backend implementation
                        url: "update_appointment_details_modal_popup.php",
                        data: {
                          id: patient_edit_id,
                          branch_name: edit_branchName,
                          doctor_name: editDoctorName,
                          appointment_date_time: editeventmodal_appointment_date_time,
                          duration_minutes: editeventmodal_duration_select,
                          reason_for_appointment: editReason
                        },
                        success: function(data) {
                          // Handle the success response
                          alert("Patient appointment updated successfully");
                          window.location.href = "app_calender.php?branch_name=" + edit_branchName;
                          // Refresh the modal content
                          // $("#editEventModal").load("modal_content.php"); // Replace "modal_content.php" with your actual content source

                          // Close the modal (if needed)
                          // $("#editEventModal").modal("hide");
                        },
                        error: function(xhr, status, error) {
                          // Handle errors
                          console.error("Error updating appointment:", error);
                        }
                      });
                    });
                  });
                </script>


                <!-- EditEvent Modal Starts -->
                <script>
                  // JavaScript to handle opening the edit popup
                  document.addEventListener('DOMContentLoaded', function() {
                    const editButton = document.getElementById('editButton');
                    const editEventModal = document.getElementById('editEventModal');
                    // const cancelEditBtn = document.getElementById('cancelEditBtn');
                    const editDoctorNameSelect = document.getElementById('editDoctorName');
                    const editeventmodal_duration_select = document.getElementById('editeventmodal_duration_select');
                    const editdoctorName = document.getElementById('doctorName').textContent;
                    const eventdetailsmodal_duration = document.getElementById('eventdetailsmodal_duration').value.trim();

                    // Add a click event listener to the "Edit" button
                    editButton.addEventListener('click', function() {
                      // Show the edit popup
                      editEventModal.style.display = 'block';

                      // Get the corresponding input element with that ID and its value
                      var popupIdInput = document.querySelector('input[name="popup_id"]');
                      var eventdetailsmodal_branch_name = document.querySelector('input[name="eventdetailsmodal_branch_name"]');
                      var onhover_appointment_date_time = document.querySelector('input[name="onhover_appointment_date_time"]');
                      var editeventmodal_appointment_date_time = document.querySelector('input[name="editeventmodal_appointment_date_time"]');

                      var patientEditIdInput = document.querySelector('input[name="patient_edit_id"]');
                      var editeventmodal_branch_name = document.querySelector('input[name="editeventmodal_branch_name"]');
                      var patientNameElement = document.getElementById('input[name="patientName"]');
                      var originalPatientName = document.getElementById('patientFirstName').textContent;
                      var originalMobileNumber = document.getElementById('contactNumber').textContent;




                      for (let i = 0; i < editeventmodal_duration_select.options.length; i++) {
                        const optionValue = editeventmodal_duration_select.options[i].value;
                        if (optionValue === eventdetailsmodal_duration) {
                          editeventmodal_duration_select.selectedIndex = i;
                          break;
                        }
                      }
                      var branchName = document.getElementById("eventdetailsmodal_branch_name").value;
                      editButtonfetchDocotrsAPI(branchName);
                      // Loop through the options in the select dropdown and set the selected option
                      // for (let i = 0; i < editDoctorNameSelect.options.length; i++) {
                      //     if (editDoctorNameSelect.options[i].text === doctorName) {
                      //         editDoctorNameSelect.selectedIndex = i;
                      //         break;
                      //     }
                      // }
                      function editButtonfetchDocotrsAPI(selectedBranch) {
                        // Make an AJAX request to fetch doctors based on the selected branch
                        fetch(`fetch_doctors.php?branch_name=${selectedBranch}`)
                          .then(response => response.json())
                          .then(data => {
                            if (data.success) {
                              console.log(data);
                              const doctors = data.doctors;
                              const editDoctorNameSelector = document.getElementById('editDoctorName');

                              // Clear the existing doctor options
                              editDoctorNameSelector.innerHTML = '';

                              // Add the new doctor options based on the response
                              doctors.forEach(doctor => {
                                const option = document.createElement('option');
                                option.value = doctor.doctor_name;
                                option.textContent = doctor.doctor_name;
                                editDoctorNameSelector.appendChild(option);
                              });

                              // Select the option based on the value received from the API
                              const editdoctorName = document.getElementById('doctorName').textContent;

                              for (let i = 0; i < editDoctorNameSelector.options.length; i++) {
                                if (editDoctorNameSelector.options[i].value === editdoctorName) {
                                  editDoctorNameSelector.selectedIndex = i;
                                  break; // Exit the loop once the value is found
                                }
                              }
                            } else {
                              console.error('Error: ' + data.message);
                            }
                          })
                          .catch(error => {
                            console.error('Error fetching doctors:', error);
                          });
                      }

                      var valueToTransfer = onhover_appointment_date_time.value;

                      // Set the value of the second form's input field
                      editeventmodal_appointment_date_time.value = valueToTransfer;
                      // Set the dynamic values in the edit modal elements
                      var editPatientNameElement = document.getElementById('editeventmodal_patientName');
                      var editMobileNumberElement = document.getElementById('editeventmodal_mobileNumber');
                      if (editeventmodal_branch_name && eventdetailsmodal_branch_name) {
                        editeventmodal_branch_name.value = eventdetailsmodal_branch_name.value;
                      }

                      if (editPatientNameElement) {
                        editPatientNameElement.textContent = originalPatientName;
                      }

                      if (editMobileNumberElement) {
                        editMobileNumberElement.textContent = originalMobileNumber;
                      }
                      // Set the value of patient_edit_id based on the value of popup_id
                      if (popupIdInput && patientEditIdInput) {
                        patientEditIdInput.value = popupIdInput.value;
                      }

                      // Get the value of patient's name
                      if (patientNameElement) {
                        var patientName = patientNameElement.textContent;
                        // Now you have the patient's name in the variable "patientName"
                        console.log("Patient's name: " + patientName);
                      }
                    });
                  });
                  document.addEventListener('DOMContentLoaded', function() {
                    // Your code here
                    document.getElementById("cancelEditBtn").addEventListener("click", function(e) {
                      e.preventDefault(); // Prevent the default behavior
                      console.log("Cancel button clicked"); // Log to the console
                      // Close the edit popup
                      editEventModal.style.display = 'none';
                    });
                  });
                </script>
                <style>
                  /* Styling for the editEventModal */
                  #editEventModal {
                    width: 80%;
                    max-height: 82%;
                    position: fixed;
                    top: 50%;
                    left: 75%;
                    transform: translate(-50%, -50%);
                  }

                  /* Styling for the card container */
                  #editEventModal .card {
                    background-color: #fff;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                    border-radius: 5px;
                    width: 100%;
                    max-width: 600px;
                    padding: 20px;
                  }

                  /* Styling for card content */
                  #editEventModal .card .card-body {
                    padding: 10px;
                    margin-top: 10px;
                  }

                  /* Additional card styles can be applied as needed */

                  /* Styling to remove the scrollbar */
                  #editEventModal body {
                    overflow: hidden;
                  }

                  /* Style for form headings */
                  #editEventModal .form-heading {
                    font-size: 18px;
                    /* Adjust the font size as needed */
                    color: #333;
                    /* Heading text color */
                    margin-top: 10px;
                    /* Adjust the top margin as needed */
                  }

                  #editEventModal .card .card-body .custom-buttons {
                    margin-top: 20px;
                  }

                  #editMinutes option {
                    padding: 5px;
                    /* Adjust the padding to control the option height */
                  }

                  #cancelEditBtn {
                    background: none;
                    border: none;
                    color: red;
                    /* Text color */
                    cursor: pointer;
                  }
                </style>
                <!-- HTML structure with the card-like appearance -->
                <div id="editEventModal" class="modal">
                  <div class="card">
                    <div class="card-body">
                      <form>
                        <input type="hidden" name="patient_edit_id" id="patient_edit_id">
                        <input type="hidden" name="editeventmodal_branch_name" id="editeventmodal_branch_name">
                        <p style="color: blue" id="editeventmodal_patientName"></p>
                        <div class="row">
                          <div class="col-md-4">
                            <p id="editeventmodal_mobileNumber"></p>
                          </div>

                        </div>
                        <hr> <!-- Divider line -->
                        <!-- <p id="doctorName"></p> -->
                        <p class="form-heading"><b>Doctor:</b></p>
                        <select id="editDoctorName" name="editDoctorName" class="form-control" style="margin-top:-10px;">

                        </select>

                        <div class="form-group">
                          <p class="form-heading"><b>Date & Time:</b></p>
                          <div class="row" style="margin-top:-10px;">
                            <div class="col-md-6">
                              <input type="datetime-local" name="editeventmodal_appointment_date_time" id="editeventmodal_appointment_date_time">
                            </div>
                          </div>
                          <p class="form-heading"><b>Duration:</b></p>
                          <select id="editeventmodal_duration_select" class="form-control" style="margin-top:-10px;">
                            <option value="5">5 minutes</option>
                            <option value="10">10 minutes</option>
                            <option value="15">15 minutes</option>
                            <option value="20">20 Minutes</option>
                            <option value="30">30 Minutes</option>
                            <option value="45">45 Minutes</option>
                            <option value="60">1 Hour</option>
                            <option value="90">1 Hours 30 Minutes</option>
                            <option value="120">2 Hours</option>
                            <option value="150">2 Hours 30 Minutes</option>
                            <option value="180">3 Hours</option>
                            <option value="360">6 Hours</option>
                            <option value="1440">Full Day</option>
                            <!-- Add other duration options here -->
                          </select>
                          <p class="form-heading"><b>Reason:</b></p>
                          <textarea id="editReason" placeholder="Reason for appointment" class="form-control" style="margin-top:-10px;"></textarea>
                          <div class="custom-buttons">
                            <button class="btn blue" id="saveEditBtn">Save</button>
                            <button class="btn red" id="cancelEditBtn">Cancel</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>

                <!-- EditEvent Modal Ends -->






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
        data: {
          branch_name: branchName
        }, // Pass the branch name as a parameter
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
            //         var title = `${appointment.patient_first_name} ${appointment.patient_last_name} (ID: ${appointment.patient_id}) - Dr. ${appointment.doctor_name}`;

            //         if (appointment.cancelled_by) {
            //   title += ` -  ${appointment.cancelled_by}`;
            // // title = `<span class="cancelled-appointment">${title} - ${appointment.cancelled_by}</span>`;
            //   // alert(appointment.cancelled_by);
            // }

            var title = `<span class="event-title">${appointment.patient_first_name} ${appointment.patient_last_name}-${appointment.patient_id}- (ID: ${appointment.id}) - Dr. ${appointment.doctor_name}`;

            if (appointment.cancelled_by) {
              title += `<span class="cancelled-by">${appointment.cancelled_by}</span>`;
            }

            title += '</span>';



            return {
              id: appointment.id,
              // title: appointment.patient_first_name + ' ' + appointment.patient_last_name,
              title: title,
              start: startDateTime.format(), // Format start time as ISO 8601
              end: endDateTime.format(), // Format end time as ISO 8601
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



    $('#calendar').on('click', '.fc-event', function() {
      var title = $(this).text(); // Get the text of the clicked event
      console.log('Clicked event title:', title); // Log the event title


      var eventId = extractIdFromTitle(title);

      if (eventId !== null) {
        get_patientdetails_with_id(eventId);
      }
    });

    function get_patientdetails_with_id(eventId) {
      // Send an AJAX request to fetch additional data based on the event ID
      $.ajax({
        url: 'get_patientdetails_with_id.php',
        type: 'GET',
        data: {
          id: eventId
        },
        success: function(data) {
          console.log("Successful return from the PHP page", data);

          // Assuming your API returns the data for the clicked event
          var appointmentInfo = data;
          try {
            // Parse the date string (assuming $appointment_date_time is a string)
            var date = new Date(appointmentInfo.appointment_date_time);
            var onhover_appointment_date_time = new Date(appointmentInfo.appointment_date_time);
            var appointmentDateTime = appointmentInfo.appointment_date_time;

            var formattedDateTime_hover = appointmentDateTime.replace(' ', 'T').slice(0, 16);

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

          // Upda1te the modal with the fetched data
          // var patientFirstNameLink = $('<a>')
          //   .attr('href', 'view_single_patient_details.php?patient_id=' + appointmentInfo.patient_id)
          //   .text(appointmentInfo.patient_first_name);
          var patientFirstNameLink = $('<a>')
            .attr('href', 'view_single_patient_details.php?patient_id=' + appointmentInfo.patient_id + '&branch_name=' + appointmentInfo.branch_name)
            .text(appointmentInfo.patient_first_name);

          $('#patientFirstName').empty().append(patientFirstNameLink);

          $('#contactNumber').text(' ' + appointmentInfo.contact_no);
          $('#on_hover_gender').text(' ' + appointmentInfo.gender);

          //var durationMinutes = parseInt(appointmentInfo.duration_minutes, 10); // Parse duration_minutes as an integer
          //$('#eventdetailsmodal_duration').val(' ' + appointmentInfo.duration_minutes);
          // Assuming appointmentInfo.duration_minutes is an integer
          var durationMinutes = parseInt(appointmentInfo.duration_minutes, 10);

          $('#eventdetailsmodal_duration').val(' ' + appointmentInfo.duration_minutes);
          $('#span_eventdetailsmodal_duration').text(' ' + durationMinutes + ' minutes');


          $('#popup_id').val(appointmentInfo.id);
          $('#appointmentStatus').val(appointmentInfo.today_status);

          $('#eventdetailsmodal_branch_name').val(appointmentInfo.branch_name);

          $('#doctorName').text('' + appointmentInfo.doctor_name);
          // alert(appointmentInfo.doctor_name);


          // Set the value of the datetime-local input field
          $('#onhover_appointment_date_time').val(formattedDateTime_hover);
          $('#appointmentTime').text('' + appointmentInfo.appointment_date_time);

          // Show the modal
          $('#eventDetailsModal').show();
        },
        error: function() {
          console.error('Failed to fetch additional event data.');
        }
      });
    }
    // Hide the modal when the close button is clicked
    $('#eventDetailsModal #closeModalBtn').click(function() {
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
          right: 'today,week,month,next'
        },
        defaultView: 'agendaDay',
        slotDuration: '00:10:00', // Set your default slot duration here
        minTime: '06:00:00',
        maxTime: '22:00:00',
        editable: true, // Enable event dragging and resizing
        eventDurationEditable: true, // Allow event duration to be editable
        events: eventsData, // Use the mapped data
        eventDragStart: function(event, jsEvent, ui, view) {
          // This function is called when an event dragging operation starts
          // You can capture the original duration_minutes value here if needed
          event.originalDurationMinutes = event.duration_minutes;
        },

        eventDragStop: function(event, jsEvent, ui, view) {
          // This function is called when an event dragging operation stops
          // Calculate the new duration_minutes based on the drag operation
          var newDurationMinutes = event.originalDurationMinutes;


          event.duration_minutes = newDurationMinutes;

          // Send an AJAX request to  the appointment's duration_minutes in your database
          $.ajax({
            url: 'update_appointment_duration.php', // Replace with your update script URL
            type: 'POST',
            data: {
              id: event.id,
              duration_minutes: newDurationMinutes
            },
            success: function(response) {
              console.log('Duration minutes updated successfully:', response.message);
            },
            error: function() {
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
            success: function(response) {
              console.log('Duration minutes updated successfully:', response.message);
            },
            error: function() {
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
              newEndTime: newEndTime.format() // Send the updated end time
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

      var branchName = "<?php echo $branch_name; ?>";
      // fetchDocotrsAPI(branchName);
      // fetchAppointments(branchName);


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
                <input type="hidden" name="patient_id" id="patient_id" value="new_patient">
                <input type="hidden" id="id" name="id">
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
                      var appointmentTimeInput = document.getElementById('appointment_date_time_database');
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

                      var formattedDateTime_for_db_op_time = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

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
                          if (ampm === 'PM' && hours !== 12) {
                            hours += 12;
                          }

                          formattedDateTime_for_db_op_time = year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;

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
                        <option value="360">6 Hours</option>
                        <option value="1440">Full Day</option>
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
                          <div class="react-autosuggest__container">



                            <input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control required-field" name="patient_first_name" placeholder="First name" id="appointment-form-patient-fname" value="" oninput="if (this.value.length >= 4) searchPatients(this.value)">
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


                                          // Update date_of_birth input and age input
                                          const dateOfBirthInput = document.getElementById('appointment-form-patient-dob');
                                          const ageInput = document.querySelector('.form-group input[type="number"]');



                                          dateOfBirthInput.value = patient.date_of_birth; // Assuming you have a date input field
                                          ageInput.value = calculateAge(patient.date_of_birth);

                                          // Function to calculate age based on date of birth
                                          function calculateAge(dateOfBirth) {
                                            const dob = new Date(dateOfBirth);
                                            const today = new Date();
                                            const age = today.getFullYear() - dob.getFullYear();

                                            // Check if the birthday has occurred this year
                                            if (today.getMonth() < dob.getMonth() || (today.getMonth() === dob.getMonth() && today.getDate() < dob.getDate())) {
                                              age--;
                                            }

                                            return age;
                                          }

                                          // Update location, area, and address placeholders
                                          const locationCityInput = document.getElementById('appointment-form-patient-location-city');
                                          const locationAreaInput = document.querySelector('.form-group input[name="location_area"]');
                                          const addressTextarea = document.getElementById('appointment-form-patient-address');

                                          locationCityInput.placeholder = patient.location_city || 'Select City';
                                          locationAreaInput.placeholder = patient.location_area || 'Select Area';
                                          addressTextarea.placeholder = patient.patient_address || 'Patient Address';

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

                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row ">
                        <div class="react-autosuggest__container" style="width: 120px; ">
                          <input type="text" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" name="patient_middle_name" placeholder="Middle name" id="appointment-form-patient-mname" value="">
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
                        <div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="patient-gender-male" name="gender" value="male"><label class="form-check-label" for="patient-gender-male">Male</label></div>
                        <div class="form-check form-check-inline"><input class="form-check-input" type="radio" id="patient-gender-female" name="gender" value="female"><label class="form-check-label" for="patient-gender-female">Female</label></div>
                      </div>
                    </div>
                    <div class="form-group"><label class="col-form-label"><span>Age</span></label>
                      <div class="form-group col-sm-9"><input id="appointment-form-patient-dob" type="date" name="date_of_birth" class="form-control  hasDatepicker" placeholder="Date of Birth" value=""><input type="number" min="0" step="1" class="form-control" placeholder="Age (in years)" value=""></div>
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
                        <div class="react-autosuggest__container"><input type="text" name="location_city" autocomplete="off" role="combobox" aria-autocomplete="list" aria-owns="react-autowhatever-1" aria-expanded="false" class="form-control" placeholder="Select City" id="appointment-form-patient-location-city" value="">
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
                      <select class="form-control" name="medical_history" id="medicalHistoryDropdown">
                        <option value="">Select...</option>
                      </select>
                    </div>


                    <script>
                      $(document).ready(function() {
                        const medicalHistoryDropdown = $('#medicalHistoryDropdown');

                        // Make an AJAX request to fetch the symptoms data
                        $.ajax({
                          url: 'api/medical-history.php', // Replace with your API endpoint
                          method: 'GET',
                          dataType: 'json',
                          success: function(data) {
                            // Iterate through the received data and add options to the dropdown
                            $.each(data.symptoms, function(index, symptom) {
                              medicalHistoryDropdown.append($('<option>', {
                                value: symptom.title,
                                text: symptom.title
                              }));
                            });
                          },
                          error: function(error) {
                            console.error('Error fetching medical history data:', error);
                          }
                        });
                      });
                    </script>


                    <div class="form-group">
                      <label class="col-form-label">Procedures</label>
                      <div class="form-group col-sm-8">
                        <select class="form-control custom-select" name="procedures" id="proceduresDropdown" style="width:100px;">
                          <option value="">Select...</option>
                        </select>
                      </div>
                    </div>


                    <script>
                      $(document).ready(function() {
                        const proceduresDropdown = $('#proceduresDropdown');

                        // Make an AJAX request to fetch the procedures data
                        $.ajax({
                          url: 'api/procedures.php', // Replace with your API endpoint
                          method: 'GET',
                          dataType: 'json',
                          success: function(data) {
                            // Iterate through the received data and add options to the dropdown
                            $.each(data.procedures, function(index, procedure) {
                              proceduresDropdown.append($('<option>', {
                                value: procedure.title,
                                text: procedure.title
                              }));
                            });
                          },
                          error: function(error) {
                            console.error('Error fetching procedures data:', error);
                          }
                        });
                      });
                    </script>


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
                        <button type="submit">Book Appointment</button>
                      </div>
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
                        padding: 0;
                        /* Remove padding to make the buttons compact */
                        border: none;
                        /* Remove borders */
                        cursor: pointer;
                        font-weight: bold;
                      }

                      .blue-text {
                        color: #0074cc;
                        /* Set the text color to blue */
                      }

                      .red-text {
                        color: #ff0000;
                        /* Set the text color to red */
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
    function updateBranchSession() {
      var selectedBranch = $("#branchSelector").val();
      alert(selectedBranch);
      // Send an AJAX request to update the session
      $.ajax({
        type: "POST",
        url: "update_session.php", // Replace with the actual server-side script to handle the session update
        data: {
          branch: selectedBranch
        },
        success: function(response) {
          console.log("Session updated successfully");
          window.location.href = "app_calender.php?branch_name=" + selectedBranch;
        },
        error: function(error) {
          console.error("Error updating session");
        }
      });
    }
  </script>

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
    firstNameInput.addEventListener("input", function() {
      validateNameInput(firstNameInput, fnameError);
    });

    middleNameInput.addEventListener("input", function() {
      validateNameInput(middleNameInput, mnameError);
    });

    lastNameInput.addEventListener("input", function() {
      validateNameInput(lastNameInput, lnameError);
    });


    // Regular expression to match valid contact numbers (digits, and optional country code)
    const contactNoRegex = /^\+?\d{1,15}$/;


    // Regular expression to match valid email addresses
    const emailRegex = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/;

    contactNoInput.addEventListener("input", function() {
      if (contactNoInput.value.trim() === "") {
        contactNoError.textContent = ""; // Clear the error message if input is empty
      } else if (!contactNoRegex.test(contactNoInput.value)) {
        contactNoError.textContent = "Enter a valid number";
      } else {
        contactNoError.textContent = ""; // Clear the error message
      }
    });

    emailAddressInput.addEventListener("input", function() {
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
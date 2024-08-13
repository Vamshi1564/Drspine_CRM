<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet" />
    <?php include("common_links.php"); ?>
<?php
session_start(); 
if (!isset($_SESSION['email'])) {
    header("Location:login.php");
    exit();
} else {
    $_SESSION['url'] = $_SERVER['REQUEST_URI'];
}
include("config.php");



// Fetch appointments from the database
$sql = "SELECT * FROM appointments";
$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = array(
            'title' => 'Appointment: ' . $row['name'],
            'start' => $row['date'] . "T" . $row['time'],
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


    <style>
        .container {
            height: 100%;
            margin-top: 10px;
            margin-right: 70px;
        }

        .card-body {
            padding: 0;
            justify-content: center;
        }

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
            z-index: 9999; /* Make sure the popup appears on top */
        }

        .popup .popup-content {
            background-color: #fff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            width: 80%; /* Adjust this value as needed */
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
</head>

<body>
    <?php include("menu.php"); ?>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Event Details Popup -->
    <div id="eventDetailsPopup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closeEventDetailsPopup()"
            style="position: absolute; top: 10px; right: 10px; font-size: 20px; cursor: pointer;color: white; background-color: red; padding: 10px;">&times;</span>

        <div id="eventDetailsContent"></div>
    </div>
</div>
   

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script>
    function openAppointmentDetailsPopup(appointmentId) {
        $.ajax({
            url: 'get_appointment_details.php',
            type: 'GET',
            data: { Id: appointmentId },
            success: function (data) {
                $('#eventDetailsContent').html(data);
                $('#eventDetailsPopup').show();
            }
        });
    }

    function closeEventDetailsPopup() {
        $('#eventDetailsPopup').hide();
        $('#eventDetailsContent').empty(); // Clear the content when closing
    }

    $(document).ready(function () {
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,today',
                center: 'title',
                right: 'agendaWeek, month, next'
            },
            defaultView: 'month',
            events: <?php echo $events_json; ?>,
            eventClick: function (calEvent, jsEvent, view) {
                if (calEvent.type === 'appointment') {
                    openAppointmentDetailsPopup(calEvent.id);
                } 
            },
        });
    });
</script>


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
</body>
</html>

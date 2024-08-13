<!DOCTYPE html>
<?php
session_start(); 
if(!isset($_SESSION['email'])){
   header("Location:login.php");
}
else{
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
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
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
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="dist/img/logo.png" alt="" height="60" width="80">
  </div>

 <?php include("menu.php");?>
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
 <?php include("footer.php");?>
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
        <span class="close" onclick="closeEventDetailsPopup()"
            style="position: absolute; top: 10px; right: 10px; font-size: 20px; cursor: pointer;color: white; background-color: red; padding: 10px;">&times;</span>

        <div id="eventDetailsContent"></div>
    </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<!-- <script src="plugins/jquery-ui/jquery-ui.min.js"></script> -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  // $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<!-- <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<!-- ChartJS -->
<!-- <script src="plugins/chart.js/Chart.min.js"></script> -->
<!-- Sparkline -->
<!-- <script src="plugins/sparklines/sparkline.js"></script> -->
<!-- JQVMap -->
<!-- <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
<!-- jQuery Knob Chart -->
<!-- <script src="plugins/jquery-knob/jquery.knob.min.js"></script> -->
<!-- daterangepicker -->
<!-- <script src="plugins/moment/moment.min.js"></script> -->
<!-- <script src="plugins/daterangepicker/daterangepicker.js"></script> -->
<!-- Tempusdominus Bootstrap 4 -->
<!-- <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script> -->
<!-- Summernote -->
<!-- <script src="plugins/summernote/summernote-bs4.min.js"></script> -->
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- <script src="dist/js/demo.js"></script> -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script src="dist/js/pages/dashboard.js"></script> -->

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
                // left: 'prev,today',
                // center: 'title',
                // right: 'agendaWeek, month, next'
              right: 'prev, today, agendaWeek, month, next'
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

<script type="text/javascript">
  (function () {
    $("#addType").on("change", function () {
        $.ajax({
            url: 'get_inventory.php',
            type: "GET",
            data: dataString,
            success: function(data) {
                $("#tablecont").html(data);
            }
        });
       });
});
</script>


    <script>
        // $(function () {
        //     $("#example1").DataTable({
        //         "responsive": false, "lengthChange": false, "autoWidth": false,
        //     }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        //     $('#example2').DataTable({
        //         "paging": true,
        //         "lengthChange": false,
        //         "searching": false,
        //         "ordering": true,
        //         "info": true,
        //         "autoWidth": false,
        //         "responsive": true,
        //     });
        // });
    </script>

</body>
</html>

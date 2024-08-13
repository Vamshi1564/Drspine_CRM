<!DOCTYPE html>
<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
} else {
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
                            <h1>Add appointments</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item active">Appointments</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>


            <!-- Main content -->

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">

                            <div class="card">
                                <div class="card-header">
                                    <div class="card-tools">
                                        <a class="btn btn-flat btn-primary" onclick="openPopup()"><span
                                                class="fas fa-plus"></span> Add Appointment</a>
                                    </div>
                                    <h3 class="card-title">All Appointments</h3>
                                </div>
                                <div class="row col-12"
                                    style="margin-top:10px; margin-left: 15px;">
                                    <form class="form-inline" method="POST" action="">
                                        <label>Date:</label>
                                        <input type="date" class="form-control" placeholder="Start" name="date1"
                                            value="<?php echo isset($_POST['date1']) ? $_POST['date1'] : '' ?>" />
                                        <label>To</label>
                                        <input type="date" class="form-control" placeholder="End" name="date2"
                                            value="<?php echo isset($_POST['date2']) ? $_POST['date2'] : '' ?>" />
                                        <button class="btn btn-primary" name="search"
                                            style="margin-left:4px;margin-right:4px;"><i class="fa fa-search"></i></button>
                                        <a href="#" type="button" class="btn btn-success"><i class="fa fa-refresh"></i></a>
                                    </form>

                                </div>

                                <?php

                                // Assuming you have a database connection established already

                                // Fetch patient data from the database
                                $sql = "SELECT * FROM appointments";
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
                                                <th>Name</th>
                                                <th>Patient Id</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <!-- <th>Time To</th> -->
                                                <th>Age</th>
                                                <!-- <th>Occupation</th> -->
                                                <th>Email</th>
                                                <!-- <th>No of Session</th> -->
                                                <th>Mobile</th>
                                                <th>Doctor</th>
                                                <!-- <th>City</th> -->
                                                <th>Issue</th>
                                                
                                                <!-- <th>Payment Status</th> -->
                                                <!-- <th>Gender</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $counter = 1;
                                            while ($row = $result->fetch_assoc()) { ?>
                                                <tr>
                                                    <td><?php echo $counter ?></td>
                                                    <td><?php echo $row["name"] ?></td>
                                                    <td><?php echo $row["patient_id"] ?></td>
                                                    <td><?php echo $row["date"] ?></td>
                                                    <td><?php echo $row["time"] ?></td>
                                                    <!-- <td><?php echo $row["time_to"] ?></td> -->
                                                    <td><?php echo $row["age"] ?></td>
                                                   
                                                    <td class="email_column"><?php echo $row["email"] ?></td>
                                                    <!-- <td><?php echo $row["no_of_session"] ?></td> -->
                                                    <td><?php echo $row["mobile"] ?></td>
                                                    <td><?php echo $row["doctor"] ?></td>
                                                   
                                                    <td class="issue"><?php echo $row["issue"] ?></td>
                                                  
                                                    
                                                    
                                                    <td>
                                                        <div class="btn-group">
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
                z-index: 9999; /* Ensure it appears on top */
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
                <span class="close" onclick="closePopup()" style="color: white; background-color: red; padding: 10px;" >&times;</span>

                <form action="appointmentdb.php" method="POST" enctype="multipart/form-data" style="width:600px;">

                    <h3>Book Appointment</h3>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="name"> Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="" required>
                        </div>


                        <div class="form-group col-md-6">
                            <label for="patient_id">Patient Id</label>
                            <input type="text" class="form-control" id="patient_id" name="patient_id" required>

                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="date">Date</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="time">Time</label>
                            <input type="time" class="form-control" id="time" name="time" required>
                        </div>
                    </div>

                    <div class="row">
    <div class="form-group col-md-6">
        <label for="age">Age</label>
        <input type="number" class="form-control" id="age" name="age" required>
    </div>
    <div class="form-group col-md-6">
        <label for="occupation">Occupation</label>
        <input type="text" class="form-control" id="occupation" name="occupation" required>
    </div>
</div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="no_of_session">No of session</label>
                            <input type="number" class="form-control" id="no_of_session" name="no_of_session">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="mobile">Mobile</label>
                            <input type="number" class="form-control" id="mobile" name="mobile" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="doctor">Doctor</label>
                            <input type="text" class="form-control" id="doctor" name="doctor" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="city">City</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="issue">Issue</label>
                            <input type="text" class="form-control" id="issue" name="issue" required>
                        </div>
                    </div>
                    <div class="row">
    <div class="form-group col-md-6">
        <label for="payment_status">Payment Status</label>
        <input type="text" class="form-control" id="payment_status" name="payment_status" required>
    </div>
    <div class="form-group col-md-6">
        <label for="gender">Gender</label>
        <input type="text" class="form-control" id="gender" name="gender" required>
    </div>
</div>
                    <center>
                        <button type="submit" class="btn btn-primary mx-1" name="save">Submit</button>
                    </center>

                </form>
            </div>
        </div>

        <?php
        // Close the database connection
        $conn->close();
        ?>


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


</body>

</html>

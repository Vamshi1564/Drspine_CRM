<html>
    <head>
<!-- Include Bootstrap CSS and JavaScript (assuming you're using Bootstrap) -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include Bootstrap Datepicker CSS and JavaScript -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
</head><body>
<!-- Your HTML structure with the date and time picker -->
<div class="daterangepicker ltr single opensleft show-calendar" style="top: 53.217px; left: auto; right: 391.163px; display: block;" data-start-date="new Date()">
    <input type="text" id="datetime-picker" class="form-control">
    <button class="cancelBtn btn btn-sm btn-default" type="button">Cancel</button>
    <button class="applyBtn btn btn-sm btn-primary" type="button">Apply</button>
</div>

<div id="appointment-date-picker" class="selected-date-time-wrapper" name="appointment_date_time">
    <span class="selected-date-time"></span>
</div>

<input type="hidden" name="appointment_date_time_database" id="appointment_date_time_database">
<input type="datetime-local" name="formatted_appointment_date_time" id="formatted_appointment_date_time" hidden>

<script>
    // Initialize the Bootstrap Datepicker
    $('#datetime-picker').datepicker({
        format: 'yyyy-mm-dd hh:ii:ss',
        autoclose: true,
    }).on('changeDate', function (e) {
        // Update the selected date and time elements
        const selectedDateTime = e.format(0); // format(0) returns the selected date and time
        $('.selected-date-time').text(selectedDateTime);
        $('#appointment_date_time_database').val(selectedDateTime);
        $('#formatted_appointment_date_time').val(selectedDateTime);
    });
</script>
</body>
</html>
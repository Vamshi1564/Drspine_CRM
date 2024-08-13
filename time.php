<!DOCTYPE html>
<html>
<head>
    <title>Date and Time Picker</title>
</head>
<body>

<h1>Show a Date and Time Control</h1>



    <!-- Clickable appointment-date-picker -->
    <div id="appointment-date-picker" class="selected-date-time-wrapper" onclick="showDateTimePicker()" name="appointment_date_time">
        <label for="appointment-date-picker"></label>
        <span class="selected-date-time"></span>
    </div>
    <!-- Hidden datetime-local input field -->
    <input type="datetime-local" id="datetime-picker" name="datetime-picker" style="display: none;" onchange="updateSelectedDateTime()">
    <br>
  
<input type="text" name="appointment_date_time_database" id="appointment_date_time_database">

    <input type="submit">
    <script>
        const appointmentTimeInput = document.getElementById('appointment_date_time_database');
const selectedDateTimeSpan = document.querySelector(".selected-date-time");
const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

const updateFormattedDateTime = (date) => {
  const options = { weekday: 'long', day: 'numeric', month: 'short', year: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true };
  const formattedDateTime = new Intl.DateTimeFormat('en-US', options).format(date);
  selectedDateTimeSpan.textContent = formattedDateTime;
  appointmentTimeInput.value = date.toISOString().replace('T', ' ').slice(0, -5);
};

const showDateTimePicker = () => {
  const datetimePicker = document.getElementById("datetime-picker");
  datetimePicker.style.display = "block";
};

const handleDatetimeChange = () => {
  const datetimePicker = document.getElementById("datetime-picker");
  const selectedDateTime = new Date(datetimePicker.value);
  if (!isNaN(selectedDateTime.getTime())) {
    updateFormattedDateTime(selectedDateTime);
  }
};

// Initialize with the current time
const currentDateTime = new Date();
updateFormattedDateTime(currentDateTime);

</script>
</body>
</html>

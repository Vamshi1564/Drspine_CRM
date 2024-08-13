<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add styles for the popover content */
        .popover-content {
            padding: 10px;
        }

        .details-row {
            margin-bottom: 10px;
        }

        .details-row p {
            margin: 0;
        }

        /* Add styles for buttons in the popover */
        .details-row button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <table id="drspine_appointment">
        <!-- Your table headers here -->
        <tbody>
            <tr>
                <!-- Table data here -->
                <td><a href="#" class="show-popover" data-appointment-id="1">Patient Details</a></td>
            </tr>
            <!-- Add more rows here -->
        </tbody>
    </table>

    <!-- Popover Container -->
    <div id="appointment-popover" class="popover">
        <div class="popover-content">
            <!-- Content from drspine_appointment goes here -->
        </div>
        <span class="close-popover">Close</span>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const popover = document.getElementById("appointment-popover");
            const showPopoverLinks = document.querySelectorAll(".show-popover");
            const closePopoverButton = document.querySelector(".close-popover");

            // Event listener for "Patient Details" links
            showPopoverLinks.forEach(link => {
                link.addEventListener("click", function (e) {
                    e.preventDefault();
                    const appointmentId = this.dataset.appointmentId;
                    //fetchAppointmentData(appointmentId);
                    fetchAppointmentData(61);
                });
            });

            // Event listener for the close button
            closePopoverButton.addEventListener("click", function () {
                popover.style.display = "none";
            });

            // Function to fetch appointment data from the server
            function fetchAppointmentData(appointmentId) {
                // Make an AJAX request to retrieve appointment data
                // Replace 'fetch_appointment.php' with your server-side script
                fetch(`fetch_appointment.php?id=${appointmentId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Format the popover content
                        const popoverContent = `
                            <h2>Appointment Details</h2>
                            <div class="details-row">
                                <p><strong>Patient Name:</strong> ${data.patient_first_name} ${data.patient_middle_name} ${data.patient_last_name}</p>
                                <p><strong>Schedule:</strong> ${data.appointment_date_time}</p>
                            </div>
                            <div class="details-row">
                                <p><strong>Mobile Number:</strong> ${data.contact_no}</p>
                                <p><strong>Doctor Name:</strong> ${data.doctor_name}</p>
                            </div>
                            <div class="details-row">
                                <p><strong>Appointment Date & Time:</strong> ${data.appointment_date_time}</p>
                            </div>
                            <div class="details-row">
                                <button class="btn-cancel">Cancel</button>
                                <button class="btn-payment">Payment</button>
                                <button class="btn-missed">Missed</button>
                                <button class="btn-followup">Follow-up</button>
                            </div>
                        `;

                        popover.querySelector(".popover-content").innerHTML = popoverContent;
                        popover.style.display = "block";
                    })
                    .catch(error => {
                        console.error('Error fetching appointment data:', error);
                    });
            }
        });
    </script>
</body>
</html>

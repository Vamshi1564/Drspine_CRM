<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <title>Dynamic Calendar with Timeslots</title>
    <style>
        /* Custom styles */
        .calendar-table {
            width: 100%;
            border-collapse: collapse;
        }
        .calendar-table th, 
        .calendar-table td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 8px;
        }
        .calendar-table th {
            background-color: #f0f0f0;
        }
        .time-slot {
            background-color: #e8f4ea;
        }
        .slot-available {
            background-color: #dff0d8;
        }
        .slot-booked {
            background-color: #f2dede;
        }
    </style>
</head>
<body>
<nav class="container-fluid">
    <!-- Navigation content -->
</nav>

<main class="container">
    <section>
        <hgroup>
            <h2>Weekly Timeslot Calendar</h2>
        </hgroup>
        <table class="calendar-table">
            <thead>
                <tr>
                    <th>Time / Date</th>
                    <!-- Generate date columns dynamically -->
                    <th>Sun 19/1</th>
                    <th>Mon 20/1</th>
                    <th>Tue 21/1</th>
                    <th>Wed 22/1</th>
                    <th>Thu 23/1</th>
                    <th>Fri 24/1</th>
                    <th>Sat 25/1</th>
                </tr>
            </thead>
            <tbody id="timeslots">
                <!-- Generate timeslots dynamically -->
                <tr>
                    <td class="time-slot">08:30 AM</td>
                    <td class="slot-available">Available</td>
                    <td class="slot-booked">Booked</td>
                    <!-- ... -->
                </tr>
                <!-- Additional rows for other timeslots -->
            </tbody>
        </table>
    </section>
</main>

<script>
    // JavaScript to dynamically generate the timeslots
    // This is a static example and would need backend data to be dynamic
    const timeslotData = {
        '08:30 AM': ['Available', 'Booked', 'Available', 'Available', 'Booked', 'Available', 'Booked'],
        '09:00 AM': ['Booked', 'Available', 'Booked', 'Booked', 'Available', 'Available', 'Booked'],
        // ... more timeslots
    };

    const timeslotsTable = document.getElementById('timeslots');

    for (const [time, slots] of Object.entries(timeslotData)) {
        const row = timeslotsTable.insertRow();
        const timeCell = row.insertCell();
        timeCell.textContent = time;
        timeCell.className = 'time-slot';

        slots.forEach(slotStatus => {
            const slotCell = row.insertCell();
            slotCell.textContent = slotStatus;
            slotCell.className = slotStatus === 'Available' ? 'slot-available' : 'slot-booked';
        });
    }
</script>

<footer class="container">
    <!-- Footer content -->
</footer>

</body>
</html>

<?php
include 'config.php';
?>
<style>
    table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #000; /* Add a border to the table */
    }

    th, td {
        text-align: center;
        vertical-align: middle;
        border: 1px solid #000; /* Add a border to table cells (th and td) */
        padding: 8px;
    }
</style>

<?php
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Fetch patient details using $id
        $sql = "SELECT * FROM appointments WHERE id = $id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $eventDetails = $result->fetch_assoc();
    ?>
    <table>
    <tr>
            <td><strong>Branch:</strong></td>
            <td><?php echo $eventDetails['branch_name']; ?></td>
        </tr>
        <tr>
            <td><strong>Patient Id:</strong></td>
            <td><?php echo $eventDetails['patient_id']; ?></td>
        </tr>
        <tr>
            <td><strong>Name:</strong></td>
            <td><?php echo $eventDetails['name']; ?></td>
        </tr>
        
        <tr>
            <td><strong>Date of Birth:</strong></td>
            <td><?php echo $eventDetails['date_of_birth']; ?></td>
        </tr>
        <tr>
            <td><strong>Age:</strong></td>
            <td><?php echo $eventDetails['age']; ?></td>
        </tr>
        <tr>
            <td><strong>Email:</strong></td>
            <td><?php echo $eventDetails['email']; ?></td>
        </tr>
      
        <tr>
            <td><strong>Mobile:</strong></td>
            <td><?php echo $eventDetails['mobile']; ?></td>
        </tr>
        <tr>
            <td><strong>Gender:</strong></td>
            <td><?php echo $eventDetails['gender']; ?></td>
        </tr>
        <tr>
            <td><strong>Occupation:</strong></td>
            <td><?php echo $eventDetails['occupation']; ?></td>
        </tr>
        <tr>
            <td><strong>Address:</strong></td>
            <td><?php echo $eventDetails['address']; ?></td>
        </tr>
        <tr>
            <td><strong>Doctor:</strong></td>
            <td><?php echo $eventDetails['doctor']; ?></td>
        </tr>
        <tr>
            <td><strong>Issue:</strong></td>
            <td><?php echo $eventDetails['issue']; ?></td>
        </tr>
        <tr>
            <td><strong>Date:</strong></td>
            <td><?php echo $eventDetails['date']; ?></td>
        </tr>
        <tr>
            <td><strong>Time From:</strong></td>
            <td><?php echo $eventDetails['time_from']; ?></td>
        </tr>
        <tr>
            <td><strong>Time To:</strong></td>
            <td><?php echo $eventDetails['time_to']; ?></td>
        </tr>
        <tr>
            <td><strong>Status :</strong></td>
            <td><?php echo $eventDetails['status']; ?></td>
        </tr>
        <tr>
            <td><strong>Payment Status:</strong></td>
            <td><?php echo $eventDetails['payment_status']; ?></td>
        </tr>
        <!-- Add more patient details here as needed -->
    </table>
    <?php
        } else {
            echo "Patient not found.";
        }
    } else {
        echo "Patient ID not provided.";
    }
    ?>

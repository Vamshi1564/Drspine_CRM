<?php
include("config.php");

if (isset($_POST['download'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // Fetch patient data based on the selected date range
    $sql = "SELECT * FROM `drspine_appointment` WHERE `appointment_date_time` BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    $result = $conn->query($sql);

    // Prepare CSV data
    //$csv_data = "Sl No,Branch Name,Patient Id,Name,Age,Email,Contact No,Gender,Doctor,Date\n";
    $csv_data = "Sl No,Branch Name,Patient Id,Name,Age,Email,Contact No,Gender,Doctor,Date,Appointment Number,No. of Booked Appointments,Status,Appointment Type,Appointment Date Time,Duration Minutes,Patient Middle Name,Patient Last Name,Patient Profile Picture,Date of Birth,Referred By,Refer Patient Type,Refer Patient Name,Location City,Location Area,Patient Address,Reason for Appointment,Case ID,Medical History,Procedures,Groups,Blood Group,Tele Appointment,Other History,Today Status,Cancelled By,Reason for Cancel,Occupation,Pincode,Treatment,Source,No. of Sessions/Plans\n";

    // while ($row = $result->fetch_assoc()) {
    //     $csv_data .= "{$row['id']},{$row['branch_name']},{$row['patient_id']},{$row['patient_first_name']},{$row['age']},{$row['email_address']},{$row['contact_no']},{$row['gender']},{$row['doctor_name']},{$row['appointment_date_time']}\n";
    // }
    while ($row = $result->fetch_assoc()) {
        $csv_data .= "{$row['id']},{$row['branch_name']},{$row['patient_id']},{$row['patient_first_name']},{$row['age']},{$row['email_address']},{$row['contact_no']},{$row['gender']},{$row['doctor_name']},{$row['appointment_date_time']},{$row['appointment_number']},{$row['no_of_booked_appointments_patient_id']},{$row['status']},{$row['appointment_type']},{$row['appointment_date_time']},{$row['duration_minutes']},{$row['patient_middle_name']},{$row['patient_last_name']},{$row['patient_profile_picture']},{$row['date_of_birth']},{$row['referred_by']},{$row['refer_patient_type']},{$row['refer_patient_name']},{$row['location_city']},{$row['location_area']},{$row['patient_address']},{$row['reason_for_appointment']},{$row['case_id']},{$row['medical_history']},{$row['procedures']},{$row['groups']},{$row['blood_group']},{$row['tele_appointment']},{$row['other_history']},{$row['today_status']},{$row['cancelled_by']},{$row['reason_for_cancel']},{$row['occupation']},{$row['pincode']},{$row['treatment']},{$row['source']},{$row['no_of_sessions_plans']}\n";
    }
    // Generate the file name based on the selected start and end dates in "dd-mm-yyyy" format
    $formatted_start_date = date("d-F-Y", strtotime($start_date));
    $formatted_end_date = date("d-F-Y", strtotime($end_date));
    $file_name = "patient_data_{$formatted_start_date}_to_{$formatted_end_date}.csv";

    // Set the appropriate headers for CSV download with the dynamic file name
    header('Content-Type: application/csv');
    header('Content-Disposition: attachment; filename="' . $file_name . '"');

    // Output the CSV data to the browser
    echo $csv_data;
    exit();
}
?>
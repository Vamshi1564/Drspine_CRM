<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
   

require 'PHPMailer-master/src/PHPMailer.php';
        require 'PHPMailer-master/src/SMTP.php';
        require 'PHPMailer-master/src/Exception.php';
        
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        // Error reporting configuration


require 'config.php';

// Include your database connection code here, e.g., require_once("db_connection.php");

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $appointment_type = isset($_POST['appointment_type']) ? $_POST['appointment_type'] : null;
$appointment_date_time = isset($_POST['appointment_date_time']) ? $_POST['appointment_date_time'] : null;
$duration_minutes = isset($_POST['duration_minutes']) ? $_POST['duration_minutes'] : null;
$doctor_name = isset($_POST['doctor_name']) ? $_POST['doctor_name'] : null;
$patient_first_name = isset($_POST['patient_first_name']) ? $_POST['patient_first_name'] : null;
$patient_middle_name = isset($_POST['patient_middle_name']) ? $_POST['patient_middle_name'] : null;
$patient_last_name = isset($_POST['patient_last_name']) ? $_POST['patient_last_name'] : null;
$patient_profile_picture = isset($_POST['patient_profile_picture']) ? $_POST['patient_profile_picture'] : null;
$contact_no = isset($_POST['contact_no']) ? $_POST['contact_no'] : null;
$email_address = isset($_POST['email_address']) ? $_POST['email_address'] : null;
$gender = isset($_POST['gender']) ? $_POST['gender'] : null;
$date_of_birth = isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : null;
$referred_by = isset($_POST['referred_by']) ? $_POST['referred_by'] : null;
$refer_patient_type = isset($_POST['refer_patient_type']) ? $_POST['refer_patient_type'] : null;
$refer_patient_name = isset($_POST['refer_patient_name']) ? $_POST['refer_patient_name'] : null;
$location_city = isset($_POST['location_city']) ? $_POST['location_city'] : null;
$location_area = isset($_POST['location_area']) ? $_POST['location_area'] : null;
$patient_address = isset($_POST['patient_address']) ? $_POST['patient_address'] : null;
$reason_for_appointment = isset($_POST['reason_for_appointment']) ? $_POST['reason_for_appointment'] : null;
$case_id = isset($_POST['case_id']) ? $_POST['case_id'] : null;
$medical_history = isset($_POST['medical_history']) ? $_POST['medical_history'] : null;
$procedures = isset($_POST['procedures']) ? $_POST['procedures'] : null;
$groups = isset($_POST['groups']) ? $_POST['groups'] : null;
$blood_group = isset($_POST['blood_group']) ? $_POST['blood_group'] : null;
$id_type = isset($_POST['id_type']) ? $_POST['id_type'] : null;
$id_number = isset($_POST['id_number']) ? $_POST['id_number'] : null;
$nh_id = isset($_POST['nh_id']) ? $_POST['nh_id'] : null;
$other_history = isset($_POST['other_history']) ? $_POST['other_history'] : null;


$notifyPatientSMS = isset($_POST['patient-notify-sms']) && $_POST['patient-notify-sms'] === 'yes' ? 'yes' : 'no';
$notifyPatientEmail = isset($_POST['patient-notify-email']) && $_POST['patient-notify-email'] === 'yes' ? 'yes' : 'no';
$notifyPatientCall = isset($_POST['patient-notify-call']) && $_POST['patient-notify-call'] === 'yes' ? 'yes' : 'no';
$notifyPatientApp = isset($_POST['patient-notify-app']) && $_POST['patient-notify-app'] === 'yes' ? 'yes' : 'no';
$notifyDoctorSMS = isset($_POST['doctor-notify-sms']) && $_POST['doctor-notify-sms'] === 'yes' ? 'yes' : 'no';
$notifyDoctorEmail = isset($_POST['doctor-notify-email']) && $_POST['doctor-notify-email'] === 'yes' ? 'yes' : 'no';
$notifyDoctorApp = isset($_POST['doctor-notify-app']) && $_POST['doctor-notify-app'] === 'yes' ? 'yes' : 'no';
$teleAppointment = isset($_POST['appointment-type-tele']) && $_POST['appointment-type-tele'] === 'yes' ? 'yes' : 'no';


    ?>
    <script>
    // Get the values of the PHP variables
    var notifyPatientEmail="<?php echo $notifyPatientEmail; ?>";
    var appointment_type = "<?php echo $appointment_type; ?>";
    var appointment_date_time = "<?php echo $appointment_date_time; ?>";
    var duration_minutes = "<?php echo $duration_minutes; ?>";
    var doctor_name = "<?php echo $doctor_name; ?>";
    var patient_first_name = "<?php echo $patient_first_name; ?>";
    var patient_middle_name = "<?php echo $patient_middle_name; ?>";
    var patient_last_name = "<?php echo $patient_last_name; ?>";
    var patient_profile_picture = "<?php echo $patient_profile_picture; ?>";
    var contact_no = "<?php echo $contact_no; ?>";
    var email_address = "<?php echo $email_address; ?>";
    var gender = "<?php echo $gender; ?>";
    var date_of_birth = "<?php echo $date_of_birth; ?>";
    var referred_by = "<?php echo $referred_by; ?>";
    var refer_patient_type = "<?php echo $refer_patient_type; ?>";
    var refer_patient_name = "<?php echo $refer_patient_name; ?>";
    var location_city = "<?php echo $location_city; ?>";
    var location_area = "<?php echo $location_area; ?>";
    var patient_address = "<?php echo $patient_address; ?>";
    var reason_for_appointment = "<?php echo $reason_for_appointment; ?>";
    var case_id = "<?php echo $case_id; ?>";
    var medical_history = "<?php echo $medical_history; ?>";
    var procedures = "<?php echo $procedures; ?>";
    var groups = "<?php echo $groups; ?>";
    var blood_group = "<?php echo $blood_group; ?>";
    var id_type = "<?php echo $id_type; ?>";
    var id_number = "<?php echo $id_number; ?>";
    var nh_id = "<?php echo $nh_id; ?>";
    var other_history = "<?php echo $other_history; ?>";
  
    // Create a message string
    var message = `
    notifyPatientEmail:${notifyPatientEmail}
  Appointment Type: ${appointment_type}
  Appointment Date and Time: ${appointment_date_time}
  Duration (minutes): ${duration_minutes}
  Doctor Name: ${doctor_name}
  Patient First Name: ${patient_first_name}
  Patient Middle Name: ${patient_middle_name}
  Patient Last Name: ${patient_last_name}
  Patient Profile Picture: ${patient_profile_picture}
  Contact No: ${contact_no}
  Email Address: ${email_address}
  Gender: ${gender}
  Date of Birth: ${date_of_birth}
  Referred By: ${referred_by}
  Refer Patient Type: ${refer_patient_type}
  Refer Patient Name: ${refer_patient_name}
  Location City: ${location_city}
  Location Area: ${location_area}
  Patient Address: ${patient_address}
  Reason for Appointment: ${reason_for_appointment}
  Case ID: ${case_id}
  Medical History: ${medical_history}
  Procedures: ${procedures}
  Groups: ${groups}
  Blood Group: ${blood_group}
  ID Type: ${id_type}
  ID Number: ${id_number}
  NH ID: ${nh_id}
  Other History: ${other_history}
  `;
  
    // Display the message in an alert box
    alert(message);
  </script>
  <?php
//     // Define the SQL statement
// $sql = "INSERT INTO drspine_appointment (appointment_type, appointment_date_time, duration_minutes, doctor_name, patient_first_name, patient_middle_name, patient_last_name, patient_profile_picture, contact_no, email_address, gender, date_of_birth, referred_by, refer_patient_type, refer_patient_name, location_city, location_area, patient_address, reason_for_appointment, case_id, medical_history, procedures, groups, blood_group, id_type, id_number, nh_id, other_history) 
// VALUES ('$appointment_type', '$appointment_date_time', '$duration_minutes', '$doctor_name', '$patient_first_name', '$patient_middle_name', '$patient_last_name', '$patient_profile_picture', '$contact_no', '$email_address', '$gender', '$date_of_birth', '$referred_by', '$refer_patient_type', '$refer_patient_name', '$location_city', '$location_area', '$patient_address', '$reason_for_appointment', '$case_id', '$medical_history', '$procedures', '$groups', '$blood_group', '$id_type', '$id_number', '$nh_id', '$other_history')";
$sql="INSERT INTO drspine_appointment (
    id,
    appointment_type,
    appointment_date_time,
    duration_minutes,
    doctor_name,
    patient_first_name,
    patient_middle_name,
    patient_last_name,
    patient_profile_picture,
    contact_no,
    email_address,
    gender,
    date_of_birth,
    referred_by,
    refer_patient_type,
    refer_patient_name,
    location_city,
    location_area,
    patient_address,
    reason_for_appointment,
    case_id,
    notify_patient_sms,
    notify_patient_email,
    notify_patient_call,
    notify_patient_app,
    notify_doctor_sms,
    notify_doctor_email,
    notify_doctor_app,
    medical_history,
    procedures,
    groups,
    blood_group,
    tele_appointment,
    id_type,
    id_number,
    nh_id,
    other_history
  ) VALUES (
    NULL,
    '$appointment_type',
    '$appointment_date_time',
    '$duration_minutes',
    '$doctor_name',
    '$patient_first_name',
    '$patient_middle_name',
    '$patient_last_name',
    '$patient_profile_picture',
    '$contact_no',
    '$email_address',
    '$gender',
    '$date_of_birth',
    '$referred_by',
    '$refer_patient_type',
    '$refer_patient_name',
    '$location_city',
    '$location_area',
    '$patient_address',
    '$reason_for_appointment',
    '$case_id',
    '$notifyPatientSMS',
    '$notifyPatientEmail',
    '$notifyPatientCall',
    '$notifyPatientApp',
    '$notifyDoctorSMS',
    '$notifyDoctorEmail',
    '$notifyDoctorApp',
    '$medical_history',
    '$procedures',
    '$groups',
    '$blood_group',
    '$teleAppointment',
    '$id_type',
    '$id_number',
    '$nh_id',
    '$other_history'
  )";
  
// Execute the SQL statement
if ($conn->query($sql) === TRUE) {
   


global $mail_admin, $mail_user,$website_name ,$website_url;

      // Create $mail_admin and $mail_user objects
    $mail_admin = new PHPMailer(true);
    $mail_user = new PHPMailer(true);
// Insertion successful, send email notifications
$website_name = "Dr SPINE";
$website_url = "https://Dr_SPINE.co/";

//echo '<script>alert("before result if  updating the payment details");</script>';
// Check if the update was successful


 // echo '<script>alert("after updating the payment details");</script>';
   try {
     // SMTP Configuration for Gmail
     $mail_user->isSMTP();
     //$mail_user->Host = 'smtp.titan.email';
     $mail_user->Host = 'smtp.hostinger.com';
     $mail_user->Port = 465;
     $mail_user->SMTPAuth = true;
     $mail_user->SMTPSecure = 'ssl';
     
       $mail_user->Username = 'infotest@iiiqai.com';
               $mail_user->Password = '@34Rf4rd';
     $mail_user->setFrom('infotest@iiiqai.com', 'Dr SPINE');

     $mail_user->addAddress($email_address, $patient_first_name);
     $mail_user->isHTML(true);
     
    
          $subject = "Your Appointment completed successfully for$website_name ($website_url) - Pateint ID: in progress";
     
     $body = "<html>";
     $body .= "<head></head>";
     $body .= "<body>";
     $body .= "<p>Dear $patient_first_name,</p>";
     $body .= "<p>Thank you for your Appointment on $website_name. We are pleased to confirm your appointment with the following details:</p>";

  // Create an HTML table
$body .= "<table style='border-collapse: collapse;'>";

$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Appointment Date & Time:</td><td style='padding: 5px; border: 1px solid black;'>$appointment_date_time</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Duration (minutes):</td><td style='padding: 5px; border: 1px solid black;'>$duration_minutes</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Doctor Name:</td><td style='padding: 5px; border: 1px solid black;'>$doctor_name</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Patient First Name:</td><td style='padding: 5px; border: 1px solid black;'>$patient_first_name</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Patient Middle Name:</td><td style='padding: 5px; border: 1px solid black;'>$patient_middle_name</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Patient Last Name:</td><td style='padding: 5px; border: 1px solid black;'>$patient_last_name</td></tr>";

$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Contact No:</td><td style='padding: 5px; border: 1px solid black;'>$contact_no</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Email Address:</td><td style='padding: 5px; border: 1px solid black;'>$email_address</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Gender:</td><td style='padding: 5px; border: 1px solid black;'>$gender</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Date of Birth:</td><td style='padding: 5px; border: 1px solid black;'>$date_of_birth</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Referred By:</td><td style='padding: 5px; border: 1px solid black;'>$referred_by</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Refer Patient Type:</td><td style='padding: 5px; border: 1px solid black;'>$refer_patient_type</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Refer Patient Name:</td><td style='padding: 5px; border: 1px solid black;'>$refer_patient_name</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Location City:</td><td style='padding: 5px; border: 1px solid black;'>$location_city</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Location Area:</td><td style='padding: 5px; border: 1px solid black;'>$location_area</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Patient Address:</td><td style='padding: 5px; border: 1px solid black;'>$patient_address</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Reason for Appointment:</td><td style='padding: 5px; border: 1px solid black;'>$reason_for_appointment</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Case ID:</td><td style='padding: 5px; border: 1px solid black;'>$case_id</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Medical History:</td><td style='padding: 5px; border: 1px solid black;'>$medical_history</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Procedures:</td><td style='padding: 5px; border: 1px solid black;'>$procedures</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Groups:</td><td style='padding: 5px; border: 1px solid black;'>$groups</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Blood Group:</td><td style='padding: 5px; border: 1px solid black;'>$blood_group</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>ID Type:</td><td style='padding: 5px; border: 1px solid black;'>$id_type</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>ID Number:</td><td style='padding: 5px; border: 1px solid black;'>$id_number</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>NH ID:</td><td style='padding: 5px; border: 1px solid black;'>$nh_id</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Other History:</td><td style='padding: 5px; border: 1px solid black;'>$other_history</td></tr>";
$body .= "</table>";

   $body .= "<p>Please keep this email for your reference. If you have any questions or need further assistance, please feel free to contact us. We look forward to serving you.</p>";
     $body .= "<p>Best regards,</p>";
     $body .= "<p>The $website_name Team</p>";
     $body .= "</body>";
     $body .= "</html>";
     
     $mail_user->Subject = $subject;
     $mail_user->Body = $body;
     
     if (!$mail_user->send()) {
       throw new Exception('Failed to send email to user: ' . $mail_user->ErrorInfo);
       //echo "<script type='text/javascript'> document.location ='services.php'; </script>";
     }
     
    
      $mail_admin->isHTML(true);
     
      $mail_admin->isSMTP();
     //$mail_admin->Host = 'smtp.titan.email';
     $mail_admin->Host = 'smtp.hostinger.com';
     $mail_admin->Port = 465;
     $mail_admin->SMTPAuth = true;
     $mail_admin->SMTPSecure = 'ssl';
  
     $mail_admin->Username = 'infotest@iiiqai.com';
               $mail_admin->Password = '@34Rf4rd';
     $mail_admin->setFrom('infotest@iiiqai.com', 'Dr SPINE');
    // $mail_admin->addAddress('koduri.bhagath@gmail.com', 'Admin');
//       $mail_admin->addAddress('Connect@Dr_SPINE.co.in', 'Dr SPINE'); 
// $mail_admin->addAddress('Admin@sheelaa.com', 'Dr SPINE Admin'); 
 
// $mail_admin->addAddress('vyshaak09@gmail.com', 'Vyshaak'); 
$mail_admin->addAddress('irctcssy@gmail.com', 'ADMIN'); 
//    $mail_admin->addAddress('varunsondekere95@gmail.com', 'Varun'); 

// $mail_admin->addAddress('venkateshhallalli5899@gmail.com', 'Venkatesh');


     
           $subject = "New Order completed successfully for $website_name ($website_url) - Pateint ID: in progress";
     
    
     $body = "<html>";
     $body .= "<head></head>";
     $body .= "<body>";
     $body .= "<p>Dear Admin,</p>";
     $body .= "<p>New order on $website_name. The order details:</p>";
     $subject = "Your Appointment completed successfully for $website_name ($website_url) - Patient ID: in progress";
     
  // Create an HTML table
$body .= "<table style='border-collapse: collapse;'>";

$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Appointment Date & Time:</td><td style='padding: 5px; border: 1px solid black;'>$appointment_date_time</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Duration (minutes):</td><td style='padding: 5px; border: 1px solid black;'>$duration_minutes</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Doctor Name:</td><td style='padding: 5px; border: 1px solid black;'>$doctor_name</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Patient First Name:</td><td style='padding: 5px; border: 1px solid black;'>$patient_first_name</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Patient Middle Name:</td><td style='padding: 5px; border: 1px solid black;'>$patient_middle_name</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Patient Last Name:</td><td style='padding: 5px; border: 1px solid black;'>$patient_last_name</td></tr>";

$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Contact No:</td><td style='padding: 5px; border: 1px solid black;'>$contact_no</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Email Address:</td><td style='padding: 5px; border: 1px solid black;'>$email_address</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Gender:</td><td style='padding: 5px; border: 1px solid black;'>$gender</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Date of Birth:</td><td style='padding: 5px; border: 1px solid black;'>$date_of_birth</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Referred By:</td><td style='padding: 5px; border: 1px solid black;'>$referred_by</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Refer Patient Type:</td><td style='padding: 5px; border: 1px solid black;'>$refer_patient_type</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Refer Patient Name:</td><td style='padding: 5px; border: 1px solid black;'>$refer_patient_name</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Location City:</td><td style='padding: 5px; border: 1px solid black;'>$location_city</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Location Area:</td><td style='padding: 5px; border: 1px solid black;'>$location_area</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Patient Address:</td><td style='padding: 5px; border: 1px solid black;'>$patient_address</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Reason for Appointment:</td><td style='padding: 5px; border: 1px solid black;'>$reason_for_appointment</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Case ID:</td><td style='padding: 5px; border: 1px solid black;'>$case_id</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Medical History:</td><td style='padding: 5px; border: 1px solid black;'>$medical_history</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Procedures:</td><td style='padding: 5px; border: 1px solid black;'>$procedures</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Groups:</td><td style='padding: 5px; border: 1px solid black;'>$groups</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Blood Group:</td><td style='padding: 5px; border: 1px solid black;'>$blood_group</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>ID Type:</td><td style='padding: 5px; border: 1px solid black;'>$id_type</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>ID Number:</td><td style='padding: 5px; border: 1px solid black;'>$id_number</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>NH ID:</td><td style='padding: 5px; border: 1px solid black;'>$nh_id</td></tr>";
$body .= "<tr><td style='padding: 5px; border: 1px solid black;'>Other History:</td><td style='padding: 5px; border: 1px solid black;'>$other_history</td></tr>";
$body .= "</table>";

   $body .= "</table>";

     $body .= "</body>";
     $body .= "</html>";
     
     $mail_admin->Subject = $subject;
     $mail_admin->Body = $body;
     
     if (!$mail_admin->send()) {
       throw new Exception('Failed to send email to admin: ' . $mail_admin->ErrorInfo);
       //echo "<script type='text/javascript'> document.location ='services.php'; </script>";
     }
     
     // Both emails sent successfully, redirect to a success page
     echo '<script>alert("Your Service request for  completed successfully.Pateint ID: in progress");</script>';
     //echo '<script>alert("Your Service request for  completed successfully.Pateint ID: ' . $in_progress . '");</script>';
     //echo "<script type='text/javascript'> document.location ='services.php'; </script>";
     exit;
   } 
catch (Exception $e) {
 echo "<script>alert('Email sending failed: " . $e->getMessage() . "');</script>";
 //echo "<script type='text/javascript'> document.location ='services.php'; </script>";
}


echo '<script>alert("Record inserted successfully!")</script>';


// Close the database connection
$conn->close();
	
	}
    else
    {
        echo "Error: " . $conn->error;
    }
}
 else {
   
    // Handle the case when the form is not submitted
    echo "Form not submitted.";
}
?>
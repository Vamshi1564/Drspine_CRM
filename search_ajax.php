<?php
// echo '<script>alert("from search ajax ")</script>';
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("config.php");

if(isset($_POST['search'])){
   $search = $_POST['search'];
  $sql = "SELECT DISTINCT patient_id, patient_first_name, contact_no, branch_name FROM drspine_appointment WHERE patient_id LIKE ? OR patient_first_name LIKE ? OR contact_no LIKE ?";
$stmt = $conn->prepare($sql);
$searchParam = "%" . $search . "%";
$stmt->bind_param("sss", $searchParam, $searchParam, $searchParam);

  
  // $sql = "SELECT DISTINCT patient_id, name, contact_no FROM drspine_appointment WHERE patient_id LIKE ? OR name LIKE ? OR contact_no LIKE ? LIMIT 5";
   //$stmt = $conn->prepare($sql);
   //$search = "%" . $search . "%";
   //$stmt->bind_param("sss", $search, $search, $search);
   $stmt->execute();
   $result = $stmt->get_result();

   if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
       echo '<div class="result" data-patient-id="'.$row['patient_id'].'" data-branch-name="'.$row['branch_name'].'">'.$row['patient_id'].' - '.$row['patient_first_name'].' - '.$row['contact_no'].'</div>';

      }
   } else {
      echo '<div class="result">No results found</div>';
   }
}
?>

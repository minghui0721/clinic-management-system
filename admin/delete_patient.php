<?php
// Assuming you have a database connection
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve the patientId from the AJAX request
  $patientId = $_POST['patientId'];

  // Deletion from patient_list table was successful, proceed with deletion from the users table
  $usersQuery = "DELETE FROM users WHERE type = 3 AND username IN (SELECT email FROM patient_list WHERE id = '$patientId')";
  $usersResult = mysqli_query($conn, $usersQuery);
 

  if ($usersResult) {
     // Perform the deletion operation on the patient_list table
    $patientQuery = "DELETE FROM patient_list WHERE id = '$patientId'";
    $patientResult = mysqli_query($conn, $patientQuery);

    if ($patientResult) {
      // Deletion from users table was successful
      echo "success";
    } else {
      // Error occurred during deletion from users table
      echo "Error: " . mysqli_error($conn);
    }
  } else {
    // Error occurred during deletion from patient_list table
    echo "Error: " . mysqli_error($conn);
  }
}
?>

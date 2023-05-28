<?php
// Assuming you have a database connection
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
  // Retrieve the form input values
  $patientId_users = $_POST['patientId_users'];
  $patientId = $_POST['patientId'];
  $name = $_POST['name'];
  $address = $_POST['address'];
  $contact = $_POST['contact'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $allergic = $_POST['allergic'];
  $other = $_POST['other1'];
  $doctorId = 0; // Assuming doctor_id is hardcoded to 0
  $type = 3; // Assuming type is hardcoded to 3

  // Prepare and execute the SQL query to update the data in the patient_list table
  $patientQuery = "UPDATE patient_list SET name = '$name', address = '$address', contact_no = '$contact', email = '$email', user_id = '$patientId_users' WHERE id = $patientId";
  $patientResult = mysqli_query($conn, $patientQuery);

  if ($patientResult) {
    // Prepare and execute the SQL query to update the data in the users table
    $usersQuery = "UPDATE users SET id = '$patientId_users', name = '$name', address = '$address', contact = '$contact', username = '$email', password = '$password', type = '$type' WHERE id = (SELECT user_id FROM patient_list WHERE id = $patientId)";
    $usersResult = mysqli_query($conn, $usersQuery);

    if ($usersResult) {
        // Prepare and execute the SQL query to update the data in the allergic table
        if (!empty($other)) {
          $allergicQuery = "UPDATE allergic SET name = '$other' WHERE patient_id = $patientId";
        } else {
          $allergicQuery = "UPDATE allergic SET name = '$allergic' WHERE patient_id = $patientId";
        }
        $allergicResult = mysqli_query($conn, $allergicQuery);

        if ($allergicResult) {
            // Data updated successfully in all tables
            header("Location: index.php?page=patients");
            exit(); // Make sure to exit after redirecting
        } else {
            // Error occurred while updating data in the allergic table
            echo "Error: " . mysqli_error($conn);
        }

    } else {
      // Error occurred while updating data in the users table
      echo "Error: " . mysqli_error($conn);
    }
  } else {
    // Error occurred while updating data in the patient_list table
    echo "Error: " . mysqli_error($conn);
  }
}
?>

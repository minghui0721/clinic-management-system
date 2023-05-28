<?php
// Assuming you have a database connection
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['patientId'])) {
  $patientId = $_GET['patientId'];

  // Prepare and execute the SQL query to retrieve the patient information
  $query = "SELECT * FROM users WHERE username IN (SELECT email FROM patient_list WHERE id = '$patientId')";
  $result = mysqli_query($conn, $query);

  if ($result) {
    $patient = mysqli_fetch_assoc($result);
    $patient['patientId'] = $patientId; // Add the patient ID to the result array
  
    // Retrieve the value of the 'name' column from the 'allergic' table
    $allergicQuery = "SELECT DISTINCT name FROM allergic WHERE patient_id = '$patientId'";
    $allergicResult = mysqli_query($conn, $allergicQuery);
  
    if ($allergicResult) {
      if(mysqli_num_rows($allergicResult) > 0) {
        $allergic = mysqli_fetch_assoc($allergicResult);
        $patient['allergicName'] = $allergic['name']; // Add the 'name' value to the result array
      } else {
        $patient['allergicName'] = "None"; // Set allergicName to "None" if there are no allergies
      }
    } else {
      // Error occurred while retrieving allergic information
      $patient['allergicName'] = "Error: " . mysqli_error($conn);
    }
  
    // Encode the response as JSON
    $response = json_encode($patient);
  
    // Display the JSON response
    echo $response;
  } else {
    // Error occurred while retrieving patient information
    echo "Error: " . mysqli_error($conn);
  }
  
} else {
  // Invalid request
  echo "Invalid request";
}
?>

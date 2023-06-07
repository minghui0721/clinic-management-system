<?php
include('db_connect.php');

// Get the form data
$remarkId = $_POST["remark_id"];
$appointmentId = $_POST["appointment_id"];
$patientId = $_POST["patient_id"];
$remarkText = $_POST["remark"];

// Update the remark in the database
$sql = "UPDATE remark SET appointment_id='$appointmentId', patient_id='$patientId', remark='$remarkText' WHERE remark_id='$remarkId'";
if ($conn->query($sql) === TRUE) {
    echo "Remark updated successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<?php
include('db_connect.php');

// Get the form data
$permissionId = $_POST["permission_id"];
$appointmentId = $_POST["appointment_id"];
$patientId = $_POST["patient_id"];
$remarkText = $_POST["remark"];

// Update the remark in the database
$sql = "UPDATE remark_permission SET appointment_id='$appointmentId', patient_id='$patientId', remark='$remarkText' WHERE permission_id='$permissionId'";
if ($conn->query($sql) === TRUE) {
    echo "Remark updated successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

<?php
include('db_connect.php');

// Get the form data
$appointmentId = $_POST["appointment_id"];
$patientId = $_POST["patient_id"];
$remarkText = $_POST["remark"];

// Insert a record into the remark_permission table
$sql = "INSERT INTO remark_permission (patient_id, status, remark, appointment_id) VALUES ('$patientId', 0, '$remarkText', '$appointmentId')";
if ($conn->query($sql) === TRUE) {
    echo "Remark permission added successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
<?php
include('db_connect.php');

// Get the form data
$appointmentId = $_POST["appointment_id"];
$patientId = $_POST["patient_id"];
$remarkText = $_POST["remark"];

// Insert the new remark into the database
$sql = "INSERT INTO remark (appointment_id, patient_id, remark, type) VALUES ('$appointmentId', '$patientId', '$remarkText', 'doctor')";
if ($conn->query($sql) === TRUE) {
    echo "Remark added successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


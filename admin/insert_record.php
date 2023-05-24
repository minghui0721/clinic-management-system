<?php
// Connect to the database
include('db_connect.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the apply_id and status from the AJAX request
$apply_id = $_POST['apply_id'];
$status = $_POST['status'];

// Insert the record into the application_success_fail table
$sql = "INSERT INTO application_success_fail (application_id, application_status) VALUES ('$apply_id', '$status')";
if ($conn->query($sql) === TRUE) {
    // Echo the status based on the inserted value
    if ($status === 'Confirmed') {
        echo "Confirmed";
    } elseif ($status === 'Rejected') {
        echo "Rejected";
    }
} else {
    echo "Error inserting record: " . $conn->error;
}

?>

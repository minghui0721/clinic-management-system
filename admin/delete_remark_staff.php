<?php
include('db_connect.php');

// Get the remark ID from the URL parameter
$permissionId = $_GET["permission_id"];

// Delete the remark from the database
$sql = "DELETE FROM remark_permission WHERE permission_id='$permissionId'";
if ($conn->query($sql) === TRUE) {
    echo "Remark deleted successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

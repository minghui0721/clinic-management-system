<?php
include('db_connect.php');

// Get the remark ID from the URL parameter
$remarkId = $_GET["remark_id"];

// Delete the remark from the database
$sql = "DELETE FROM remark WHERE remark_id='$remarkId'";
if ($conn->query($sql) === TRUE) {
    echo "Remark deleted successfully.";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>

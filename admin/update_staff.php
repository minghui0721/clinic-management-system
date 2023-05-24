<?php
// Establish a database connection (replace with your actual database credentials)
include('db_connect.php');

// Retrieve the query from the form data
$query = $_POST['query'];

// Execute the query
if ($conn->query($query) === TRUE) {
    // Query executed successfully
    echo "1"; // Return a response indicating success
} else {
    // Failed to execute the query
    echo $conn->error; // Return a response indicating failure
}

?>

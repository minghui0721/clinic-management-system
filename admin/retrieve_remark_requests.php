<?php
// Assuming you have a database connection established
include('db_connect.php');


// Retrieve remark requests from the database
$query = "SELECT * FROM remark_permission";
$result = mysqli_query($conn, $query);

// Display the requests
while ($row = mysqli_fetch_assoc($result)) {
  echo "<tr>";
  echo "<td>{$row['permission_id']}</td>";
  echo "<td>{$row['patient_id']}</td>";
  echo "<td>{$row['appointment_id']}</td>";
  echo "<td>{$row['remark']}</td>";
  echo "<td><input type='number' id='status_{$row['permission_id']}' value='{$row['status']}'></td>";
  echo "</tr>";
}
?>

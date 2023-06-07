<?php
// Assuming you have a database connection established
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the permission ID and new status from the POST data
  $permissionId = $_POST['permission_id'];
  $newStatus = $_POST['status'];

  // Retrieve the current status from the database
  $selectQuery = "SELECT status FROM remark_permission WHERE permission_id = '$permissionId'";
  $selectResult = mysqli_query($conn, $selectQuery);
  $row = mysqli_fetch_assoc($selectResult);
  $currentStatus = $row['status'];

  if ($newStatus !== $currentStatus) {
    // Update the status in the database
    $updateQuery = "UPDATE remark_permission SET status = '$newStatus' WHERE permission_id = '$permissionId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
      // Status updated successfully
      echo "success";

      if ($newStatus === '1') {
        // Check if a remark already exists for the appointment ID
        $checkQuery = "SELECT COUNT(*) as count FROM remark WHERE appointment_id = (SELECT appointment_id FROM remark_permission WHERE permission_id = '$permissionId')";
        $checkResult = mysqli_query($conn, $checkQuery);
        $checkRow = mysqli_fetch_assoc($checkResult);
        $remarkCount = $checkRow['count'];

        if ($remarkCount === '0') {
          // Insert a record into the remark table
          $selectQuery = "SELECT * FROM remark_permission WHERE permission_id = '$permissionId'";
          $selectResult = mysqli_query($conn, $selectQuery);
          $row = mysqli_fetch_assoc($selectResult);

          $appointmentId = $row['appointment_id'];
          $patientId = $row['patient_id'];
          $remark = $row['remark'];

          $insertQuery = "INSERT INTO remark (appointment_id, patient_id, remark, type) VALUES ('$appointmentId', '$patientId', '$remark', 'staff')";
          mysqli_query($conn, $insertQuery);
        }
      }
    } else {
      // Error updating status
      echo "error";
    }
  } else {
    // No status change, only update the remark_permission table
    $updateQuery = "UPDATE remark_permission SET status = '$newStatus' WHERE permission_id = '$permissionId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
      // Status updated successfully
      echo "success";
    } else {
      // Error updating status
      echo "error";
    }
  }
}
?>

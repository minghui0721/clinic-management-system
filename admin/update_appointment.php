<?php
include 'db_connect.php';

// Retrieve the appointment ID from the URL
if (isset($_GET['id'])) {
    $appointment_id = $_GET['id'];

    // Sanitize the input to prevent SQL injection
    $appointment_id = mysqli_real_escape_string($conn, $appointment_id);

    // Retrieve appointment details with the specified ID from the appointment_list table
    $query = "SELECT id, doctor_id, patient_id, schedule, services, status FROM appointment_list WHERE id = '$appointment_id'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        // Display appointment details in a form
        echo "<form action='update_appointment.php' method='POST'>";
        
        while ($row = mysqli_fetch_assoc($result)) {
            echo "ID: <input type='text' name='id' value='".$row['id']."' readonly><br>";
            echo "Doctor ID: <input type='text' name='doctor_id' value='".$row['doctor_id']."' readonly><br>";
            echo "Patient ID: <input type='text' name='patient_id' value='".$row['patient_id']."' readonly><br>";
            echo "Schedule: <input type='datetime-local' name='schedule' value='".date('Y-m-d\TH:i', strtotime($row['schedule']))."'><br>";
            
            echo "Services: <select name='services'>";
            
            // Retrieve options from the medical_specialty table
            $options_query = "SELECT name FROM medical_specialty";
            $options_result = mysqli_query($conn, $options_query);

            if ($options_result) {
                // Add default option
                echo "<option value='".$row['services']."' ".$selected.">".$row['services']."</option>";
        
                 while ($option_row = mysqli_fetch_assoc($options_result)) {
                    $selected = ($row['services'] == $option_row['name']) ? 'selected' : '';
                    echo "<option value='".$option_row['name']."' ".$selected.">".$option_row['name']."</option>";
                }
            } else {
                echo "Error retrieving service options: " . mysqli_error($conn);
            }
        
            echo "</select><br>";
            
            echo "Status: <select name='status'>
                      <option value='0' ".($row['status'] == '0' ? 'selected' : '').">Pending Request</option>
                      <option value='1' ".($row['status'] == '1' ? 'selected' : '').">Confirmed</option>
                      <option value='2' ".($row['status'] == '2' ? 'selected' : '').">Reschedule</option>
                      <option value='3' ".($row['status'] == '3' ? 'selected' : '').">Done</option>
                      </select><br>";
        }

        echo "<input type='submit' value='Update'>";
        echo "</form>";
    } else {
        echo "Error retrieving appointment details: " . mysqli_error($conn);
    }
} else {
    echo "Appointment ID not specified in the URL.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $id = $_POST['id'];
    $schedule = $_POST['schedule'];
    $services = $_POST['services'];
    $status = $_POST['status'];

    // Sanitize the input to prevent SQL injection
    $id = mysqli_real_escape_string($conn, $id);
    $schedule = mysqli_real_escape_string($conn,$schedule);
    $services = mysqli_real_escape_string($conn, $services);
    $status = mysqli_real_escape_string($conn, $status);

    // Update the appointment details in the database
    $update_query = "UPDATE appointment_list SET schedule = '$schedule', services = '$services', status = '$status' WHERE id = '$id'";
    $update_result = mysqli_query($conn, $update_query);

    if ($update_result) {
        echo "Appointment details updated successfully.";
        header("Location: index.php?page=appointments");
        exit();
    } else {
        echo "Error updating appointment details: " . mysqli_error($conn);
        header("Location: index.php?page=appointments");
        exit();
    }
}
?>

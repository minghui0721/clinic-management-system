<?php
include 'admin/db_connect.php';

// I created another variable to store the session value
// Before Editing
$appointment_id = $_GET['id'];

$query = "SELECT * FROM appointment_list WHERE id = $appointment_id";
$results = mysqli_query($conn,$query);
$row = mysqli_fetch_assoc($results);

$service = $row['services'] ;
$date_time = $row['schedule'] ;

// Split date and time from $date_time variable
$date_time_parts = explode(' ', $date_time);
$date = $date_time_parts[0];
$time = $date_time_parts[1];

// Extract hours and minutes from $time variable
$time_parts = explode(':', $time);
$hours = $time_parts[0];
$minutes = $time_parts[1];


// After Editing and Click Submit - data Will be inserted into database
if(isset($_POST['btnSubmit'])){
    $service = $_POST['service'];
    $date = $_POST['date'];
    $time = $_POST['time'];

    // Combine date and time into a single datetime value
    $datetime = $date . ' ' . $time;

    // Query
    $query = "UPDATE `appointment_list` SET `services`='$service', `schedule`='$datetime' WHERE `id`=$appointment_id";

    // Run
    if(mysqli_query($conn, $query)){
        echo "<script>alert('Appointment successfully edited!'); setTimeout(function() {window.location.href='manage_appointment.php';}, 0);</script>";
    }

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit_appointment.css?v=<?php echo time(); ?>.css">
</head>
<body>
    <div id="container">
        
        <!-- THE INFO -->
        <form method="post" id="confirm_form">
            <div id="info">

                <div id="appointment">
                    <h2>Edit Appointment</h2>
                    <h3>Services</h3>
                    <label>
                        <input type="radio" name="service" value="Virtual Consultation" <?php if($service == "Virtual Consultation") echo "checked"; ?> required>Virtual Consultation
                    </label>
                    
                    <label>
                        <input type="radio" name="service" value="Ophthalmology" <?php if($service == "Ophthalmology") echo "checked"; ?> required>Ophthalmology
                    </label>
                    
                    <label>
                        <input type="radio" name="service" value="Orthopedics" <?php if($service == "Orthopedics") echo "checked"; ?> required>Orthopedics
                    </label>

                    <label>
                        <input type="radio" name="service" value="Urology" <?php if($service == "Urology") echo "checked"; ?> required>Urology
                    </label>

                    <h3>Appointment Date</h3>
                    <input type="date" name="date" id="confirm_date" value="<?php echo $date?>">

                    <h3>Appointment Time</h3>
                    <input type="time" name="time" id="confirm_time" value="<?php echo $hours . ':' . $minutes ?>">
                </div>
            </div>

            <div id="info2">            
                    <!-- Check box -->
                    <div id="rules">
                        <input type="checkbox" name="confirm" id="confirm" required>
                        I' ve read and confirmed the informationas
                    </div>
         
                    <!-- Submit Button -->
                    <input type="submit" name="btnSubmit" value="Confirm the changes">
            </div>
        </form>

    </div>

</body>
</html>
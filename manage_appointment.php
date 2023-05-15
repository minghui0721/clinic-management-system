<?php
// Retrieve the Patient ID
// Retrieve the Patient ID
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'admin/db_connect.php';



// Show all appointments records for the user
// Create the Query
$query = "SELECT id, doctor_id, patient_id, schedule, status, date_created, services FROM appointment_list WHERE patient_id =" . $_SESSION['login_id'];

// Run Query
$results = mysqli_query($conn, $query);

// This line initializes an empty array named $appointments, which will be used to store the appointment data retrieved from the database.
$appointments = array(); // initialize the appointments array

if (mysqli_num_rows($results) > 0) {
    // Process the results
    while($row = mysqli_fetch_assoc($results)) {
        // These lines retrieve the individual fields of the current row from the $row associative array and assign them to separate variables for easier processing.
        $appointment_id = $row["id"];
        $doctor_id = $row["doctor_id"];
        $appointment_service = $row["services"];
        $appointment_time = $row["schedule"];
        $date_created = $row["date_created"];
        $appointment_status = $row["status"];

        // This line creates an associative array named $appointment that contains the appointment data for the current row. The keys of the array (id, date, time, and status) correspond to the fields of the appointment, and their values represent the data for each field.
        $appointment = array(
            'id' => $appointment_id,
            'doctor_id' => $doctor_id,
            'service' => $appointment_service,
            'time' => $appointment_time,
            'date_created' => $date_created,
            'status' => $appointment_status
        );

        // This line adds the current $appointment associative array to the $appointments array using the array_push() function. This adds a new element to the end of the $appointments array containing the appointment data for the current row.
        array_push($appointments, $appointment);
    }
}

if(isset($_GET['id'])){ // check if the 'id' parameter is passed in the URL
    $appointment_id = $_GET['id'];

    // Delete query
    $query = "DELETE FROM `appointment_list` WHERE `id`= $appointment_id";

    if(mysqli_query($conn, $query)){ // execute the query and check if it was successful
        echo "<script>alert('Record deleted successfully!'); setTimeout(function() {window.location.href='index.php?page=manage_appointment';}, 0);</script>";
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($conn) . "');</script>";
    }
}


?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WELL</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="manage_appointment.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="../logo.png" type="image/x-icon">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .container2 {
            margin-top:80px;
            flex: 1;
            overflow-y: auto;
            padding-top: 20px; /* Add padding to create space between header and table */
            padding-bottom: 20px; /* Add padding to create space between table and footer */
        }

        /* Table */
        .table h2{
            text-align: center;
            font-size: 28px;
            margin-bottom:30px;
        }

        thead th {
            position: sticky;
            top: 0;
            background-color: #225584;
            color: #f4eee6;
            font-weight: bold;
        }


        table {
            border-collapse: collapse;
            width: 100%;
            height: 100px;
            overflow-y: auto;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 15px;
        }
        
        th {
            background-color: #225584;
            color: #f4eee6;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        
        tr:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    
    
    <!-- Appointment Table -->
    <div class="container2">
        <div class="table">
            <h2>Appointment List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Service</th>
                        <th>Doctor ID</th>
                        <th>Time</th>
                        <th>Status (0= for verification, 1=confirmed,2= reschedule,3=done)</th>
                        <th>Date created</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // if there is more than 1 array in the 'appointments' arrays
                    if (count($appointments) > 0) {
                        // loop through the $appointments and assign the current array (appointment record) to $appointment
                        foreach ($appointments as $appointment) {
                            echo "<tr>";
                            echo "<td>" . $appointment['id'] . "</td>";
                            echo "<td>" . $appointment['service'] . "</td>";
                            echo "<td>" . $appointment['doctor_id'] . "</td>";
                            echo "<td>" . $appointment['time'] . "</td>";
                            echo "<td>" . $appointment['status'] . "</td>";
                            echo "<td>" . $appointment['date_created'] . "</td>";
                    
                            // Edit hyperlink
                            echo "<td><a href='index.php?page=edit_appointment&id=" . $appointment['id'] . "'>Edit</a></td>";

                    
                            // Delete hyperlink with appointment ID as parameter. Append the patient ID to the manage_appointment.php URL
                            echo "<td><a href='manage_appointment.php?id=" . $appointment['id'] . "&patient_id=" . $_SESSION['login_id'] . "'>Delete</a></td>";
                    
                            echo "</tr>";}
                    } else {
                            echo "<tr><td colspan='4'>No records found</td></tr>";
                        }
                    ?>
                </tbody>
            </table>

        </div>
    </div>
</body>
</html>


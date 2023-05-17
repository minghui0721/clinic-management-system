
<?php
// Assuming you have a database connection established

// Retrieve appointment records with status = 3
$query = "SELECT id, schedule, services, status FROM appointment_list WHERE status = 3";
$result = mysqli_query($conn, $query);

// Process the retrieved records
if (mysqli_num_rows($result) > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>Appointment ID</th>";
    echo "<th>Schedule</th>";
    echo "<th>Services</th>";
    echo "<th>Payment Status</th>";
    echo "</tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $schedule = $row['schedule'];
        $services = $row['services'];
        $status = $row['status'];
        
        echo "<tr>";
        echo "<td>$id</td>";
        echo "<td>$schedule</td>";
        echo "<td>$services</td>";
        // Display payment status based on the value
        echo "<td>";
        if ($status == 3) {
            echo "<a href='index.php?page=payment&appointment_id=$id'>Not Paid</a>";
        } else {
            echo "Paid";
        }
        echo "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "No appointment records found.";
}


?>

<head>

    <style>

        thead th {
            position: sticky;
            top: 0;
            background-color: #225584;
            color: #f4eee6;
            font-weight: bold;
        }


        table {
            margin-top:100px;
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

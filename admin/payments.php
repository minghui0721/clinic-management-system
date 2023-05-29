<!DOCTYPE html>
<html>
<head>
  <title>Payment Details</title>
  <style>
    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
  </style>
</head>
<body>
  <h2>Payment Details</h2>

  <?php
  // Create a connection
  include('db_connect.php');

  // SQL query to retrieve payment details
  $sql = "SELECT * FROM payment";

  // Execute the query
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    // Display the table header
    echo "<table>";
    echo "<tr><th>#</th><th>Payment ID</th><th>Patient ID</th><th>Name</th><th>Option</th><th>Date</th></tr>";

    // Counter for numbering the rows
    $counter = 1;

    // Fetch and display each row of payment details
    while ($row = $result->fetch_assoc()) {
        // Get the appointment ID for each payment
        $appointmentID = $row['appointment_id'];
    
        // SQL query to retrieve patient ID from appointments
        $appointmentSql = "SELECT * FROM appointment_list WHERE id = $appointmentID";
    
        // Execute the appointment query
        $appointmentResult = $conn->query($appointmentSql);
    
        // Check if the appointment is found
        if ($appointmentResult->num_rows > 0) {
            $appointmentRow = $appointmentResult->fetch_assoc();
            $patient_id = $appointmentRow['patient_id'];
    
            // Retrieve the patient's name from the "users" table
            $name_query = "SELECT name FROM users WHERE id = $patient_id";
            $name_result = mysqli_query($conn, $name_query);
    
            if ($name_result) {
                $name_row = mysqli_fetch_assoc($name_result);
                $patient_name = $name_row['name'];
    
                // Now you have the patient's name and can use it as needed
            } else {
                echo "Error retrieving patient's name: " . mysqli_error($conn);
            }
    
            // Display the payment details with the associated patient ID
            echo "<tr>";
            echo "<td>".$counter."</td>";
            echo "<td>".$row["payment_id"]."</td>";
            echo "<td>".$appointmentRow["patient_id"]."</td>";
            echo "<td>".$patient_name."</td>";
            echo "<td>".$row["payment_option"]."</td>";
            echo "<td>".$row["created_date"]."</td>";
            echo "</tr>";
    
            $counter++;
        } else {
            // Handle the case when the appointment is not found
            echo "<tr>";
            echo "<td>".$counter."</td>";
            echo "<td>".$row["payment_id"]."</td>";
            echo "<td>N/A</td>";
            echo "<td>".$row["name"]."</td>";
            echo "<td>".$row["payment_option"]."</td>";
            echo "<td>".$row["created_date"]."</td>";
            echo "</tr>";
    
            $counter++;
        }
    }

   


    

    echo "</table>";
  } else {
    echo "No payment details found.";
  }

  ?>

</body>
</html>

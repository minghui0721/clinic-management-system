<?php
// Connect to the database
include('db_connect.php');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve data from the 'application-form' table
$sql = "SELECT af.apply_id, af.name, af.job_name, af.email, af.contact_number, af.work_experience, asf.application_status
        FROM `application-form` af
        LEFT JOIN `application_success_fail` asf ON af.apply_id = asf.id";
$result = $conn->query($sql);

// Create the HTML table
$table = "<table style='width: 100%; border-collapse: separate; border-spacing: 0;'>";
$table .= "<tr style='background-color: #f2f2f2;'><th style='border: 1px solid black; padding: 8px;'>Name</th><th style='border: 1px solid black; padding: 8px;'>Job Name</th><th style='border: 1px solid black; padding: 8px;'>Email</th><th style='border: 1px solid black; padding: 8px;'>Contact Number</th><th style='border: 1px solid black; padding: 8px;'>Work Experience</th><th style='border: 1px solid black; padding: 8px;'>Actions</th></tr>";

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        $table .= "<tr>";
        $table .= "<td style='border: 1px solid black; padding: 8px;'>" . $row["name"] . "</td>";
        $table .= "<td style='border: 1px solid black; padding: 8px;'>" . $row["job_name"] . "</td>";
        $table .= "<td style='border: 1px solid black; padding: 8px;'>" . $row["email"] . "</td>";
        $table .= "<td style='border: 1px solid black; padding: 8px;'>" . $row["contact_number"] . "</td>";
        $table .= "<td style='border: 1px solid black; padding: 8px;'>" . $row["work_experience"] . "</td>";
        $table .= "<td id='action-" . $row["apply_id"] . "' style='border: 1px solid black; padding: 8px;'>";
        
        if (!empty($row["application_status"])) {
            // If application_status is set, display it
            $table .= $row["application_status"];
        } else {
            // Otherwise, display the buttons
            $table .= "<button onclick='updateStatus(\"confirm\", " . $row["apply_id"] . ")' style='background-color: #4CAF50; color: white; border: none; padding: 5px 10px; margin-right: 5px;'>Confirm</button>";
            $table .= "<button onclick='updateStatus(\"reject\", " . $row["apply_id"] . ")' style='background-color: #f44336; color: white; border: none; padding: 5px 10px;'>Reject</button>";
        }
        
        $table .= "</td>";
        $table .= "</tr>";
    }
} else {
    $table .= "<tr><td colspan='6' style='text-align: center; padding: 8px;'>No applications found.</td></tr>";
}

$table .= "</table>";

// Output the table
echo $table;
?>

<script>
function updateStatus(action, apply_id) {
    // Update the "Actions" column based on the button clicked
    if (action === "confirm") {
        document.getElementById("action-" + apply_id).innerHTML = "Confirmed";
        // Send AJAX request to insert record into application_success_fail table
        insertRecord(apply_id, "Confirmed");
    } else if (action === "reject") {
        document.getElementById("action-" + apply_id).innerHTML = "Rejected";
        // Send AJAX request to insert record into application_success_fail table
        insertRecord(apply_id, "Rejected");
    }
}

function insertRecord(apply_id, status) {
    // Send AJAX request to insert record into application_success_fail table
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            // Update the "Actions" field with the returned status
            document.getElementById("action-" + apply_id).innerHTML = this.responseText;
        }
    };
    xhttp.open("POST", "insert_record.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("apply_id=" + apply_id + "&status=" + status);
}
</script>

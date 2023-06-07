<?php
include('db_connect.php');

// Retrieve remarks with type "doctor"
$sql = "SELECT * FROM remark_permission";
$result = $conn->query($sql);

// Generate HTML representation of remarks
$html = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= "<div class='remark'>";
        $html .= "<label for='remark-id'>Permission ID:</label><input type='text' id='remark-id' value='" . $row["permission_id"] . "' readonly>";
        $html .= "<label for='appointment-id'>Appointment ID:</label><input type='text' id='appointment-id' value='" . $row["appointment_id"] . "' readonly>";
        $html .= "<label for='patient-id'>Patient ID:</label><input type='text' id='patient-id' value='" . $row["patient_id"] . "' readonly>";
        $html .= "<label for='remark-text'>Remark:</label><input type='text' id='remark-text' value='" . $row["remark"] . "' readonly>";
        $html .= "<label for='status-text'>Status (0=Pending, 1=Approved):</label><input type='text' id='status-text' value='" . $row["status"] . "' readonly>";
        $html .= "<button class='edit-btn' onclick='editRemark(" . $row["permission_id"] . ", \"" . $row["appointment_id"] . "\", \"" . $row["patient_id"] . "\", \"" . $row["remark"] . "\", " . $row["status"] . ")'>Edit</button>";
        $html .= "<button class='delete-btn' onclick='deleteRemark(" . $row["permission_id"] . ")'>Delete</button>";
        $html .= "</div>";
    }
} else {
    $html .= "No Record Found";
}

echo $html;

$conn->close();
?>
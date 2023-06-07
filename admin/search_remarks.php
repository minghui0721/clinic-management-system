<?php

include('db_connect.php');

// Retrieve remarks with type "doctor" based on search input
$searchKeyword = $_GET['search'];
$sql = "SELECT * FROM remark WHERE type = 'doctor' AND remark LIKE '%$searchKeyword%'";
$result = $conn->query($sql);

// Generate HTML representation of remarks
$html = "";
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $html .= "<div class='remark'>";
        $html .= "<label for='remark-id'>Remark ID:</label><input type='text' id='remark-id' value='" . $row["remark_id"] . "' readonly>";
        $html .= "<label for='appointment-id'>Appointment ID:</label><input type='text' id='appointment-id' value='" . $row["appointment_id"] . "' readonly>";
        $html .= "<label for='patient-id'>Patient ID:</label><input type='text' id='patient-id' value='" . $row["patient_id"] . "' readonly>";
        $html .= "<label for='remark-text'>Remark:</label><input type='text' id='remark-text' value='" . $row["remark"] . "' readonly>";
        $html .= "<button class='edit-btn' onclick='editRemark(" . $row["remark_id"] . ", \"" . $row["appointment_id"] . "\", \"" . $row["patient_id"] . "\", \"" . $row["remark"] . "\")'>Edit</button>";
        $html .= "<button class='delete-btn' onclick='deleteRemark(" . $row["remark_id"] . ")'>Delete</button>";
        $html .= "</div>";
    }
} else {
    $html = "<p>No remarks found.</p>";
}

echo $html;

$conn->close();

?>

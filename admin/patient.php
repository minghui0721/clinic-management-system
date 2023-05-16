<?php
ob_start(); // Start output buffering

require_once 'db_connect.php';
require_once 'tcpdf/tcpdf.php';

// Retrieve user records of type 3 (patients)
$sql = "SELECT id, name, address, contact, username FROM users WHERE type = 3";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    ob_end_clean(); // Clear the output buffer

    // Create a new PDF instance
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    // Set document information
    $pdf->SetCreator('Your Website');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Patient Records');
    $pdf->SetSubject('Patient Records Report');

    // Add a new page
    $pdf->AddPage();

    // Set font
    $pdf->SetFont('helvetica', 'B', 14);

    // Output clinic name
    $clinicName = 'Poliklinik Koh';
    $pdf->Cell(0, 10, $clinicName, 0, 1, 'C');

    // Set font for report name
    $pdf->SetFont('helvetica', 'B', 12);

    // Output report name
    $reportName = 'Patient Report';
    $pdf->Cell(0, 10, $reportName, 0, 1, 'C');

    // Set font for table
    $pdf->SetFont('helvetica', '', 8);

    // Set cell margins
    $pdf->setCellMargins(0, 0, 0, 0);

    // Set maximum width for each column
    $columnWidths = [10, 30, 70, 30, 40];

    // Output the column headers
    $pdf->Cell($columnWidths[0], 10, 'ID', 1, 0, 'C');
    $pdf->Cell($columnWidths[1], 10, 'Name', 1, 0, 'C');
    $pdf->Cell($columnWidths[2], 10, 'Address', 1, 0, 'C');
    $pdf->Cell($columnWidths[3], 10, 'Contact', 1, 0, 'C');
    $pdf->Cell($columnWidths[4], 10, 'Username', 1, 1, 'C');

    // Output the records
    while ($row = mysqli_fetch_assoc($result)) {
        // Check if adding a new record will cause an overflow
        if ($pdf->GetY() + 10 > $pdf->getPageHeight() - $pdf->getMargins()['bottom']) {
            $pdf->AddPage(); // Add a new page if there is not enough space
        }

        // Output the record
        for ($i = 0; $i < count($columnWidths); $i++) {
            $pdf->Cell($columnWidths[$i], 10, $row[array_keys($row)[$i]], 1, 0, 'C');
        }
        $pdf->Ln(); // Move to the next line
    }

    // Close and output the PDF
    $pdf->Output('patient_records.pdf', 'D');
} else {
    ob_end_clean(); // Clear the output buffer
    echo 'No patient records found.';
}

mysqli_close($conn);
?>

<?php
ob_start(); // Start output buffering

require_once 'db_connect.php';
require_once 'tcpdf/tcpdf.php';

// Retrieve doctor records
$sql = "SELECT id, name, contact, email, clinic_address FROM doctors_list";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    ob_end_clean(); // Clear the output buffer

    // Create a new PDF instance
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    // Set document information
    $pdf->SetCreator('Your Website');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Doctor Records');
    $pdf->SetSubject('Doctor Records Report');

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
    $reportName = 'Doctor Report';
    $pdf->Cell(0, 10, $reportName, 0, 1, 'C');

    // Set font for table
    $pdf->SetFont('helvetica', '', 8);

    // Set cell margins
    $pdf->setCellMargins(0, 0, 0, 0);

    // Set maximum width for each column
    $columnWidths = [10, 30, 40, 40, 60];

    // Calculate table width
    $tableWidth = array_sum($columnWidths);

    // Calculate horizontal offset to center the table
    $horizontalOffset = ($pdf->getPageWidth() - $tableWidth) / 2;

    // Output the column headers with horizontal offset
    $pdf->SetX($horizontalOffset);
    $pdf->Cell($columnWidths[0], 10, 'ID', 1, 0, 'C');
    $pdf->Cell($columnWidths[1], 10, 'Name', 1, 0, 'C');
    $pdf->Cell($columnWidths[2], 10, 'Contact', 1, 0, 'C');
    $pdf->Cell($columnWidths[3], 10, 'Email', 1, 0, 'C');
    $pdf->Cell($columnWidths[4], 10, 'Clinic Address', 1, 1, 'C');

    // Output the records with horizontal offset
    while ($row = mysqli_fetch_assoc($result)) {
        // Check if adding a new record will cause an overflow
        if ($pdf->GetY() + 10 > $pdf->getPageHeight() - $pdf->getMargins()['bottom']) {
            $pdf->AddPage(); // Add a new page if there is not enough space
        }

        // Output the record with horizontal offset
        $pdf->SetX($horizontalOffset);
        $pdf->Cell($columnWidths[0], 10, $row['id'], 1, 0, 'C');
        $pdf->Cell($columnWidths[1], 10, $row['name'], 1, 0, 'C');
        $pdf->Cell($columnWidths[2], 10, $row['contact'], 1, 0, 'C');
        $pdf->Cell($columnWidths[3], 10, $row['email'], 1, 0, 'C');
        $pdf->Cell($columnWidths[4], 10, $row['clinic_address'], 1, 1, 'C');
        }

        // Close and output the PDF
        $pdf->Output('doctor_records.pdf', 'D');
    } else {
        ob_end_clean(); // Clear the output buffer
        echo 'No doctor records found.';
    }
            
?>


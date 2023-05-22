<?php
ob_start(); // Start output buffering

require_once 'db_connect.php';
require_once 'tcpdf/tcpdf.php';

// Retrieve staff records
$sql = "SELECT staff_id, name, address, contact_number, address, email, salary FROM staff_list";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    ob_end_clean(); // Clear the output buffer

    // Create a new PDF instance
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    // Set document information
    $pdf->SetCreator('Your Website');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Staff Records');
    $pdf->SetSubject('Staff Records Report');

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
    $reportName = 'Staff Report';
    $pdf->Cell(0, 10, $reportName, 0, 1, 'C');

    // Set font for table
    $pdf->SetFont('helvetica', '', 8);

    // Set cell margins
    $pdf->setCellMargins(0, 0, 0, 0);

    // Set maximum width for each column
    $columnWidths = [15, 20, 40, 35, 40, 20];

    // Calculate the center position for the table
    $tableWidth = array_sum($columnWidths);
    $tableX = ($pdf->getPageWidth() - $tableWidth) / 2;

    // Set the X and Y position for the table
    $pdf->SetXY($tableX, $pdf->GetY() + 10);

    // Output the column headers
    $pdf->Cell($columnWidths[0], 10, 'Staff ID', 1, 0, 'C');
    $pdf->Cell($columnWidths[1], 10, 'Name', 1, 0, 'C');
    $pdf->Cell($columnWidths[2], 10, 'Address', 1, 0, 'C');
    $pdf->Cell($columnWidths[3], 10, 'Contact', 1, 0, 'C');
    $pdf->Cell($columnWidths[4], 10, 'Email', 1, 0, 'C');
    $pdf->Cell($columnWidths[5], 10, 'Salary', 1, 1, 'C');

    // Output the records
    while ($row = mysqli_fetch_assoc($result)) {
        // Check if adding a new record will cause an overflow
        if ($pdf->GetY() + 10 > $pdf->getPageHeight() - $pdf->getMargins()['bottom']) {
            $pdf->AddPage(); // Add a new page if there is not enough space
        }

        // Set the X and Y position for the record
        $pdf->SetXY($tableX, $pdf->GetY());

        // Output the record
        for ($i = 0; $i < count($columnWidths); $i++) {
            $pdf->Cell($columnWidths[$i], 10, $row[array_keys($row)[$i]], 1, 0, 'C');
        }
            $pdf->Ln(); // Move to the next line
        }
        
        // Close and output the PDF
        $pdf->Output('staff_records.pdf', 'D');
        } else {
            ob_end_clean(); // Clear the output buffer
            echo 'No staff records found.';
        }
    
        ?>
        
        

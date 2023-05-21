<?php
ob_start(); // Start output buffering

require_once 'db_connect.php';
require_once 'tcpdf/tcpdf.php';

// Retrieve payment records
$sql = "SELECT payment_id, appointment_id, payment_option, employee_name, created_date, 'RM75.00' AS total FROM payment";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    ob_end_clean(); // Clear the output buffer

    // Create a new PDF instance
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');

    // Set document information
    $pdf->SetCreator('Your Website');
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Sales Report');
    $pdf->SetSubject('Sales Report');

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
    $reportName = 'Sales Report';
    $pdf->Cell(0, 10, $reportName, 0, 1, 'C');

    // Set font for table
    $pdf->SetFont('helvetica', '', 8);

    // Set cell margins
    $pdf->setCellMargins(0, 0, 0, 0);

    // Set maximum width for each column
    $columnWidths = [20, 30, 30, 40, 40, 30];

    // Output the column headers
    $pdf->Cell($columnWidths[0], 10, 'Payment ID', 1, 0, 'C');
    $pdf->Cell($columnWidths[1], 10, 'Appointment ID', 1, 0, 'C');
    $pdf->Cell($columnWidths[2], 10, 'Payment Option', 1, 0, 'C');
    $pdf->Cell($columnWidths[3], 10, 'Serve by Employee', 1, 0, 'C');
    $pdf->Cell($columnWidths[4], 10, 'Payment datetime', 1, 0, 'C');
    $pdf->Cell($columnWidths[5], 10, 'Total', 1, 1, 'C');

    // Output the records
    $totalSales = 0; // Variable to store total sales
    while ($row = mysqli_fetch_assoc($result)) {
        // Check if adding a new record will cause an overflow
        if ($pdf->GetY() + 10 > $pdf->getPageHeight() - $pdf->getMargins()['bottom']) {
            $pdf->AddPage(); // Add a new page if there is not enough space
        }

                // Output the record
                for ($i = 0; $i < count($columnWidths); $i++) {
                    $pdf->Cell($columnWidths[$i], 10, $row[array_keys($row)[$i]], 1, 0, 'C');
                }
        
                // Calculate total sales
                $totalSales += 75.00;
        
                $pdf->Ln(); // Move to the next line
            }
        
            // Output the total sales
            $pdf->SetFont('helvetica', 'B', 10);
            $pdf->Cell(array_sum($columnWidths) - $columnWidths[count($columnWidths) - 1], 10, 'Total Sales', 1, 0, 'R');
            $pdf->Cell($columnWidths[count($columnWidths) - 1], 10, 'RM' . number_format($totalSales, 2), 1, 1, 'C');
        
            // Close and output the PDF
            $pdf->Output('sales_report.pdf', 'D');
        } else {
            ob_end_clean(); // Clear the output buffer
            echo 'No sales records found.';
        }
        
        
?>
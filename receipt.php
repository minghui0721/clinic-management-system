<?php
// Assuming you have established a database connection
include('admin/db_connect.php');

// Retrieve the appointment ID from the URL
$appointmentID = $_GET['appointment_id'];

// Perform a database query to fetch the payment information based on the appointment ID
$query = "SELECT created_date, payment_id FROM payment WHERE appointment_id = $appointmentID";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $createdDateTime = $row['created_date'];
  $receiptID = $row['payment_id'];

  // Split the created_date into date and time components
  $createdDate = date('Y-m-d', strtotime($createdDateTime));
  $createdTime = date('H:i:s', strtotime($createdDateTime));
} else {
  // Handle the case when the payment information is not found
  $createdDate = "";
  $createdTime = "";
  $receiptID = "";
}

$service_query = "SELECT services FROM appointment_list WHERE id = '$appointmentID'";
$service_result = mysqli_query($conn, $service_query);
if ($service_result && mysqli_num_rows($service_result) > 0) {
  $service_row = mysqli_fetch_assoc($service_result);
  $services = $service_row['services'];
}

?>


<!DOCTYPE html>
<html>
<head>
  <title>Receipt - Poliklinik Koh</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.5;
      margin: 20px;
      background-color: #f4f4f4;
    }

    h1 {
      color: #225584;
      font-size: 24px;
      margin-bottom: 20px;
    }

    .receipt-container {
      border: 1px solid #ccc;
      padding: 20px;
      background-color: #fff;
    }

    .receipt-header {
      margin-bottom: 20px;
    }

    .receipt-header h2 {
      color: #225584;
      font-size: 20px;
      margin: 0;
    }

    .receipt-info {
      margin-bottom: 20px;
    }

    .receipt-info p {
      margin: 5px 0;
    }

    .receipt-items {
      margin-bottom: 20px;
    }

    .receipt-items table {
      width: 100%;
      border-collapse: collapse;
    }

    .receipt-items th,
    .receipt-items td {
      padding: 5px;
      border-bottom: 1px solid #ccc;
    }

    .receipt-items th {
      text-align: left;
      font-weight: bold;
    }

    .receipt-items td {
      text-align: right;
    }

    .receipt-total {
      text-align: right;
    }

    .receipt-footer {
      margin-top: 20px;
      text-align: center;
    }
  </style>

</head>
<body>
  <h1>Receipt</h1>

  <div class="receipt-container">
    <div class="receipt-header">
      <h2>Poliklinik Koh</h2>
    </div>

    <div class="receipt-info">
      <p>Date: <?php echo $createdDate; ?></p>
      <p>Receipt ID: <?php echo $receiptID; ?></p>
    </div>

    <div class="receipt-items">
      <table>
        <tr>
          <th>Description</th>
          <th>Amount</th>
        </tr>
        <tr>
          <td>Doctor Consultation</td>
          <td>RM15.00</td>
        </tr>
        <tr>
          <td><?php echo $services ?></td>
          <td>RM60.00</td>
        </tr>
        <!-- Add more rows for additional services or items -->
      </table>
    </div>

    <div class="receipt-total">
      <p>Total: RM75.00</p>
    </div>

    <div class="receipt-footer">
      <p>Thank you for choosing Poliklinik Koh!</p>
      <button onclick="window.print()">Print</button>
    </div>
  </div>

  <script>
    // Retrieve appointment ID from the URL
    var urlParams = new URLSearchParams(window.location.search);
    var appointmentId = urlParams.get('appointment_id');

    // Retrieve date and receipt ID from the payment data
    var date = '[retrieve date from payment table]';
    var receiptId = '[retrieve receipt ID from payment table]';

    // Set the values in the receipt
    document.getElementById('appointment-id').textContent = appointmentId;
    document.getElementById('receipt-date').textContent = date;
    document.getElementById('receipt-id').textContent = receiptId;
  </script>
</body>
</html>


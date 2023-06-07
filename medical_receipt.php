<!DOCTYPE html>
<html>
<head>
  <title>Medical Receipt - Poliklinik Koh</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.5;
      margin: 20px;
      margin-top: 100px;
      background-color: #f4f4f4;
    }

    h1 {
      color: #225584;
      font-size: 24px;
      margin-bottom: 20px;
    }

    .options-section {
      margin-top: 30px;
      border: 1px solid #ccc;
      padding: 20px;
      background-color: #fff;
    }

    .option {
      margin-bottom: 10px;
      display: flex;
      align-items: center;
    }

    .option label {
      display: block;
      font-weight: bold;
      margin-left: 10px;
    }

    .option input{
      margin-top: -5px;
    }
  </style>
</head>
<body>
  <h1>Medical Receipt</h1>

  <div class="options-section">
    <div class="option">
      <input type="radio" id="medical-leave-option" name="receipt-option" value="medical-leave">
      <label for="medical-leave-option">Medical Leave</label>
    </div>

    <div class="option">
      <input type="radio" id="receipt-option" name="receipt-option" value="receipt">
      <label for="receipt-option">Receipt</label>
    </div>
  </div>

  <script>
    // Retrieve the appointment ID from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const appointmentID = urlParams.get('appointment_id');

    // Redirect to PHP file based on user selection
    document.addEventListener('DOMContentLoaded', function() {
      var medicalLeaveOption = document.getElementById('medical-leave-option');
      var receiptOption = document.getElementById('receipt-option');

      medicalLeaveOption.addEventListener('change', function() {
        window.open('medical_leave.php?appointment_id=' + appointmentID, '_blank');
      });

      receiptOption.addEventListener('change', function() {
        window.open('receipt.php?appointment_id=' + appointmentID, '_blank');
      });
    });
  </script>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
  <title>Remark Requests by Staff</title>
  <link rel="stylesheet" type="text/css" href="request.css">
</head>
<body>
  <h1>Remark Request Page</h1>

  <table>
    <tr>
      <th>Permission ID</th>
      <th>Patient ID</th>
      <th>Appointment ID</th>
      <th>Remark</th>
      <th>Status (0=Pending, 1=Approved)</th>

    </tr>
    <?php include 'retrieve_remark_requests.php'; ?>
  </table>

  <script src="request.js"></script>
</body>
</html>

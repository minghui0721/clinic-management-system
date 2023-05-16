<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin-top: 30px;
            display: flex;
            justify-content: center;
        }

        li {
            margin-right: 20px;
        }

        li a {
            display: block;
            background-color: #eaeaea;
            padding: 10px 20px;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        li a:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <h1>Select a Report</h1>
    <ul>
        <li><a href="patient.php">Patient Report</a></li>
        <li><a href="staff.php">Staff Report</a></li>
        <li><a href="doctor.php">Doctor Report</a></li>
        <li><a href="sales.php">Sales Report</a></li>
    </ul>
</body>
</html>

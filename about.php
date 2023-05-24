<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>

        h2 {
            text-align: center;
            color: #333;
        }

        .container_setting{
            margin-top:0 auto;
            margin-top:-90px;
            height:750px;
            padding: 20px;
        }

        .about-item {
            margin-bottom: 50px;
        }

        .about-item label {
            font-weight: bold;
        }

        .about-item span {
            margin-left: 5px;
        }

        table {
        border-collapse: collapse;
        width: 100%;
        

    }

    th, td {
        text-align: center;
        padding: 8px;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }



    </style>
</head>
<body>


    <!-- Masthead-->
    <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4" style="background: #0000002e;">
                    	 <h1 class="text-uppercase text-white font-weight-bold">About Us</h1>
                        <hr class="divider my-4" />
                    </div>
                </div>
            </div>
    </header>


    <table>
        <tr>
            <th>Day</th>
            <th>Opening Hours</th>
        </tr>
        <tr>
            <td>Monday</td>
            <td>10:00 AM - 7:00 PM</td>
        </tr>
        <tr>
            <td>Tuesday</td>
            <td>10:00 AM - 7:00 PM</td>
        </tr>
        <tr>
            <td>Wednesday</td>
            <td>10:00 AM - 7:00 PM</td>
        </tr>
        <tr>
            <td>Thursday</td>
            <td>10:00 AM - 7:00 PM</td>
        </tr>
        <tr>
            <td>Friday</td>
            <td>Close</td>
        </tr>
        <tr>
            <td>Saturday</td>
            <td>10:00 AM - 7:00 PM</td>
        </tr>
        <tr>
            <td>Sunday</td>
            <td>10:00 AM - 7:00 PM</td>
        </tr>
    </table>

    <section class="page-section">
        <div class="container_setting">
        <?php echo html_entity_decode($_SESSION['setting_about_content']) ?>        
        </div>
    </section>
</body>
</html>

 
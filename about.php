<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .about-container {
            width: 600px;
            margin: 0 auto;
            font-family: Arial, sans-serif;
        }

        h2 {
            text-align: center;
            color: #333;
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

    <section class="page-section">
        <div class="container">
        <?php echo html_entity_decode($_SESSION['setting_about_content']) ?>        
        </div>
    </section>
</body>
</html>

 
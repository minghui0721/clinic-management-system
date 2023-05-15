<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cashier Details</title>    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;700&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/03e0369c68.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="cashier_style.css?v=<?php echo time(); ?>">
</head>
<body>

    <!-- back button -->
    <button class="back_button" onclick="window.history.back()">
        <i class="fa-solid fa-caret-left"></i> Back
    </button>

    <div class="web-container">

        <!-- picture -->
        <div class="image">
            <img src="cashier.png" alt="nursing.png" width="750px">
        </div>


        <div class="detail-text">
            <!-- title -->
            <h1>Cashier</h1>

            <!-- description -->
            <p>
                As a cashier at Well Medical Care Centre, you will be responsible for managing patient payments and 
                ensuring the accuracy of financial transactions. You need to provide excellent customer service and 
                maintain a professional and friendly demeanor at all times. Your main duties will include verifying 
                patient insurance coverage, processing co-pays and deductibles, and balancing cash drawers at the end 
                of each shift. In this role, attention to detail, strong communication skills, and the ability to work 
                in a fast-paced environment are essential. At Well Medical Care Centre, we value the important role that 
                our cashiers play in providing excellent patient experiences, and we provide them with the necessary 
                training and resources to succeed in their positions.
            </p>

            <br><br>
            <h2>Benefits:</h2>
            <ul>
                <li>Remuneration package provided based on experience which includes EPF, Socso, and SIP.</li>
                <li>Performance Bonus (Yearly)</li>
                <li>Professional training</li>
                <li>Accommodation may be provided according to individual needs.</li>
            </ul>

            <br><br>
            <h2>Requirement:</h2>
            <ul>
                <li>Candidate must possess at least a SPM/STPM or Diploma/Degree in Accounting.</li>
                <li>Good command in English and Bahasa Malaysia both written and spoken.</li>
                <li>Good interpersonal and communication skills</li>
                <li>1 year experience in related works</li>
                <li>Able to work on rotational shift including weekends and public holidays.</li>
                <li>Three shifts job for part-time (7am-2pm, 2pm-9pm, 0pm-7am)</li>
            </ul>

            <br>
            <h3>Job type:</h3>
            <p style="font-size: 20px; margin-top: 0px;">
                Full-time/Part-Time
            </p>

            <h3>Salary:</h3>
            <p style="font-size: 18px; margin-top: 0px;">
                RM1,800 - RM2,800
            </p>
        </div>

        <!-- apply button -->
        <div class="apply-boxes">
            <a href="apply_form.php" target="_blank">
                <button class="apply-button">
                    Apply Now
                </button>
            </a>
        </div>
    </div>
</body>
</html>
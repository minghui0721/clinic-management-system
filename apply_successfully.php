<!-- move the 'apply-id' variable from 'apply_form.php' -->
<?php
include 'admin/db_connect.php';

session_start();
$apply_id=$_SESSION['apply_id'];

$query="SELECT * FROM `application-form` WHERE apply_id='$apply_id'";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_assoc($result);

mysqli_close($conn);
?>

<!-- inform webpage -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Successfully</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;700&display=swap" rel="stylesheet">
	<link rel="shorcut icon" type="Iamge" href="logo.png">
    <link rel="stylesheet" type="text/css" href="apply_form_php_style.css">
</head>
<body>
<div class="information_container">
        <div class="information_text">    
            <h2>Submit Successfully</h2>
            <p>Our staff will review your application and email to you soon.</p><hr>
            <p>Your apply id:&nbsp; <?php echo $row['apply_id'] ?></p>
            <p>Name:&nbsp; <?php echo $row['name']?></p>
            <p>Job Name:&nbsp; <?php echo $row['job_name']?></p>
            <p>Job Type:&nbsp; <?php echo $row['job_type']?></p>
            <p>Gender:&nbsp; <?php echo $row['gender']?></p>
            <p>IC Number:&nbsp; <?php echo $row['ic_number']?></p>
            <p>Email:&nbsp; <?php echo $row['email']?></p>
            <p>Contact Number:&nbsp; <?php echo $row['contact_number']?></p>
            <p>Work Experience (Year):&nbsp; <?php echo $row['work_experience']?></p>
            <p>Address:&nbsp; <?php echo $row['address']?></p>

            <a class="nav-link js-scroll-trigger" href="index.php?page=career">
                <button class="back_button" style= 'margin-top: 70px;'>
                    Back
                </button>
            </a>
        </div>
    </div>
</body>
</html>
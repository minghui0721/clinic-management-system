<!-- save the customer data in php variable -->
<?php
session_start();

if(isset($_POST['submit'])){
    $_SESSION['name']=$_POST['first-name'] . ' ' . $_POST['last-name'];
    $_SESSION['ic-number']=$_POST['ic-number'];
    $_SESSION['gender']=$_POST['gender'];
    $_SESSION['contact-number']=$_POST['contact-number'];
    $_SESSION['work-experience']=$_POST['work-experience'];
    $_SESSION['job-name']=$_POST['job-name'];
    $_SESSION['job-type']=$_POST['job-type'];
    $_SESSION['email']=$_POST['email'];
    $_SESSION['address']=$_POST['address'];
}
?>

<!-- table for cuatomer make double confirm -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information Confirm | Well Medical</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;700&display=swap" rel="stylesheet">
	<link rel="shorcut icon" type="Iamge" href="../logo.png">
    <link rel="stylesheet" type="text/css" href="apply_form_php_style.css">
</head>
<body>
    <div class="information_container">
        <div class="information_text">
            <h2>Information Confirm</h2>
            <p>Please double check your personal detials...</p><hr>
            <p>Name:&nbsp; <?php echo $_SESSION['name']?></p>
            <p>Job Name:&nbsp; <?php echo $_SESSION['job-name']?></p>
            <p>Job Type:&nbsp; <?php echo $_SESSION['job-type']?></p>
            <p>Gender:&nbsp; <?php echo $_SESSION['gender']?></p>
            <p>IC Number:&nbsp; <?php echo $_SESSION['ic-number']?></p>
            <p>Email:&nbsp; <?php echo $_SESSION['email']?></p>
            <p>Contact Number:&nbsp; <?php echo $_SESSION['contact-number']?></p>
            <p>Work Experience (Year):&nbsp; <?php echo $_SESSION['work-experience']?></p>
            <p>Address:&nbsp; <?php echo $_SESSION['address']?></p>


            <form action="#" method= 'post'>
                <input type="submit" value="submit" name="second_submit">
            </form>
            
            <a href="apply_form.php">
                <button class="back_button">
                    Back
                </button>
            </a>
        </div>

    </div>
</body>
</html>

<!-- submit the enquiry data into database -->
<?php
include 'admin/db_connect.php';


if(isset($_POST['second_submit'])){
    $name=$_SESSION['name'];
    $job_name=$_SESSION['job-name'];
    $job_type=$_SESSION['job-type'];
    $gender=$_SESSION['gender'];
    $ic_number=$_SESSION['ic-number'];
    $email=$_SESSION['email'];
    $contact_number=$_SESSION['contact-number'];
    $work_experience=$_SESSION['work-experience'];
    $address=$_SESSION['address'];

    $query="INSERT INTO `application-form`(`name`, `job_name`, `job_type`, `gender`, `ic_number`, `email`, `contact_number`, `work_experience`, `address`) 
    VALUES ('$name','$job_name','$job_type','$gender','$ic_number','$email','$contact_number',' $work_experience','$address')";

    if (mysqli_query($conn,$query)){
        $query="SELECT * FROM `application-form` WHERE name='$name' AND job_name='$job_name' AND job_type='$job_type' AND ic_number='$ic_number' ORDER BY apply_id DESC";
        $result=mysqli_query($conn,$query);
        $row=mysqli_fetch_assoc($result);
        $_SESSION['apply_id']=$row['apply_id'];
        header('Location:apply_successfully.php');
    }
}

mysqli_close($conn)
?>
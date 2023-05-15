<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="apply_form_style.css?v=<?php echo time(); ?>apply_form_style.css">
    <script src="email-validation.js"></script>
	<script src="phone-validation.js"></script>
	<script src="ic-validation.js"></script>
</head>
<body>
    <div class="page-title">
        <h1>Job Application Form</h1>
    </div>

    <!-- the box for the form -->
    <div class="form-container">
        <form action="confirm_apply_form.php" method="post">
            <div class="name-box">
                <div class="first-name-box">
                    <p>First Name:</p>
                    <input type="text"  id="first-name" name="first-name" required>
                </div>

                <div class="last-name-box">
                    <p>Last Name:</p>
                    <input type="text"  id="last-name" name="last-name" required>
                </div>
            </div>

            
            <!-- column for the first name and last name -->
            <div class="ic-number-and-gender-box">
                <div class="ic-number-box">
                    <p>IC Number (xxxxxx-xx-xxxx):</p>
                    <input type="text"  id="ic-number" name="ic-number" required>
                </div>
                
                
                <div class="gender-box">
                    <p>Gender:</p>
                        <label><input type="radio" name="gender" value="Male" required>Male</label>
                        <label><input type="radio" name="gender" value="Female" required>Female</label>
                </div>
            </div>

            
            <!-- column for the contact number and work experience -->
            <div class="contact-number-and-work-experience-box">
                <div class="contact-number-box">
                    <p>Contact Number:</p>
                    <input type="tel"  id="contact-number" name="contact-number" required>
                </div>

                <div class="work-experience-box">
                    <p>Work Experience (year):</p>
                    <input type="number"  id="work-experience" name="work-experience" required>
                </div>
            </div>


            <!-- column for the job name and job type -->
            <div class="job-name-and-job-type-box">
                <div class="job-name-box">
                    <p>Job Name:</p>
                    <select name="job-name" id="job-name" required>
						<option value="Nursing">Nursing</option>
						<option value="Pharmacist">Pharmacist</option>
						<option value="Cashier">Cashier</option>
						<option value="Cleaner">Cleaner</option>
					</select>
                </div>

                <div class="job-type-box">
                    <p>Job Type:</p>
                    <select name="job-type" id="job-type" required>
						<option value="Full-time">Full-time</option>
						<option value="Part-time">Part-time</option>
					</select>
                </div>
            </div>


            <!-- column for the email -->
            <div class="email-box">
                <p>Email:</p>
                <input type="email"  id="email" name="email" required>
            </div>


            <!-- column for the address -->
            <div class="address-box">
                <p>Address:</p>
                <textarea name="address" id="" cols="60" rows="5" required></textarea>
            </div>


            <script>
                function validateForm() {
                  var emailValid = ValidateEmail(document.getElementById('email'));
                  var phoneValid = ValidatePhone(document.getElementById('contact-number'));
                  var ICValid = ValidateIC(document.getElementById('ic-number'));
                  return emailValid && phoneValid && ICValid;
                }
            </script>
            <div class="apply-button">
                    <input type="submit" value="Apply" name="submit" onclick="return validateForm();">
            </div>
        </form>
    </div>
</body>
</html>
<?php
include 'admin/db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

    // PHP code to perform the database query and generate the token
    $resetEmail = $_POST['email'];

    // Check if the email exists in the database
    $qry = "SELECT * FROM users WHERE username = '$resetEmail'";
    $results = mysqli_query($conn,$qry);
    $row = mysqli_fetch_assoc($results);

    if ($row) {
        $user_id = $row['id'];

        // Generate a unique token for password reset
        $token = bin2hex(random_bytes(32));

        // Store the token in the database along with the user ID and expiration time
        $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $insert_query = "INSERT INTO password_reset_tokens (user_id, token, expiry_time) VALUES ('$user_id', '$token', '$expiry_time')";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            $mail = new PHPMailer(true);

            try {
                // $mail->SMTPAutoTLS = false;
                $mail->isSMTP();
                // Configure your SMTP settings
                $mail->Host = 'sandbox.smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Port = 2525;
                $mail->Username = '4f03d301383242';
                $mail->Password = 'fa00ebce445d74';
                $mail->SMTPSecure = 'tls';
    
                // Recipients
                $mail->setFrom('mywellcare12@gmail.com', 'Well Care');
                $mail->addAddress($resetEmail); // Recipient's email

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset';
                $mailContent = '<h1>Reset Password</h1>
                    <p>Click the following link to reset your password:</p>
                    <p><a href="http://localhost/WDT012023/clinic_management_system/reset_password.php?token=' . $token . '">Reset Password</a></p>';            
                $mail->Body = $mailContent;
    
                $mail->send();
                echo '1'; // Email sent successfully
            } catch (Exception $e) {
                echo '2'; // Email could not be sent
            }
        } else {
            echo '2'; // Database query or insert failed
        }
    } else {
        // Email does not exist
        echo '3';
    }
?>
<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);

try {
    $mail->SMTPAutoTLS = false;
    $mail->isSMTP();

    // Configure your SMTP settings
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'mywellcare12@gmail.com';
    $mail->Password = 'wellcareappointment';

    // Recipients
    $mail->setFrom('mywellcare12@gmail.com', 'well care');
    $mail->addAddress('ganminghui0000@gmail.com'); // Recipient's email

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset';
    $mail->Body = "Click the following link to reset your password";
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;

    $mail->send();
    echo 'Email sent successfully';
} catch (Exception $e) {
    echo 'Email could not be sent. Error: ' . $e->getMessage();
        }


?>

<?php
include('admin/db_connect.php');


if (isset($_POST['submit'])) {


    // Get the form data
    $appointmentId = $_POST['appointment_id'];
    $paymentOption = $_POST['payment_option'];
    $employeeName = $_POST['staff_option'];

    // Insert the payment details into the database
    $insertQuery = "INSERT INTO `payment` (`appointment_id`, `payment_option`, `employee_name`) VALUES ('$appointmentId', '$paymentOption', '$employeeName')";
    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        header("Location: index.php?page=manage_payment");
        $responseMessage = "Payment submitted successfully.";
        exit();
        // You can assign a success message or redirect the user to another page here
    } else {
        $responseMessage = "Error submitting payment: " . mysqli_error($conn);
    }

    // Display the response message
    echo "<div>$responseMessage</div>";
}
?>


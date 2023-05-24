<?php
include 'admin/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $user_id = $_POST['user_id'];
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the form data
    if ($new_password !== $confirm_password) {
        echo 'The new password and confirm password do not match.';
        exit;
    }

    // Check if the token is valid
    $qry = "SELECT * FROM password_reset_tokens WHERE token = '$token' AND user_id = '$user_id'";
    $results = mysqli_query($conn, $qry);
    $row = mysqli_fetch_assoc($results);

    if ($row) {
        // Update the user's password
        $hashed_password = md5($new_password);
        $update_query = "UPDATE users SET password = '$hashed_password' WHERE id = '$user_id'";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            // Delete the used password reset token from the table
            $delete_query = "DELETE FROM password_reset_tokens WHERE token = '$token'";
            mysqli_query($conn, $delete_query);

            echo 'Password updated successfully. You can now <a href="index.php">login</a> with your new password.';
        } else {
            echo 'Password update failed. Please try again.';
        }
    } else {
        echo 'Invalid token. Password update failed.';
    }
} else {
    echo 'Invalid request. Please submit the password reset form.';
}
?>

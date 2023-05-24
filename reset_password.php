<?php
include 'admin/db_connect.php';

// Check if the token is provided in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Retrieve the corresponding user from the password_reset_tokens table
    $qry = "SELECT * FROM password_reset_tokens WHERE token = '$token'";
    $results = mysqli_query($conn, $qry);
    $row = mysqli_fetch_assoc($results);

    if ($row) {
        // Check if the token has expired
        $expiryTime = strtotime($row['expiry_time']);
        $currentTime = time();
        if ($expiryTime >= $currentTime) {
            // Token is valid and not expired
            $user_id = $row['user_id'];

            // Display the password reset form
            echo '
            <form action="update_password.php" method="POST">
                <input type="hidden" name="user_id" value="' . $user_id . '">
                <input type="hidden" name="token" value="' . $token . '">
                <div>
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>
                </div>
                <div>
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                </div>
                <button type="submit">Reset Password</button>
            </form>
            ';
        } else {
            // Token has expired
            echo 'The password reset link has expired. Please request a new one.';
        }
    } else {
        // Token is invalid
        echo 'Invalid token. Please request a new password reset link.';
    }
} else {
    // Token is not provided in the URL
    echo 'Invalid request. Please provide a valid password reset token.';
}
?>

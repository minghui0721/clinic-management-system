<?php
include 'admin/db_connect.php';

// Variable to store error or success message
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $user_id = $_POST['user_id'];
    $token = $_POST['token'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate the form data
    if ($new_password !== $confirm_password) {
        $message = 'The new password and confirm password do not match.';
    } else {
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

                // Set success message
                $message = 'Password updated successfully.';
            } else {
                $message = 'Password update failed. Please try again.';
            }
        } else {
            $message = 'Invalid token. Password update failed.';
        }
    }
} else {
    $message = 'Invalid request. Please submit the password reset form.';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            margin-top: 0;
        }

        form {
            max-width: 400px;
            margin-top: 20px;
        }

        label,
        input {
            display: block;
            margin-bottom: 10px;
        }

        input[type="password"] {
            width: 100%;
            padding: 10px;
        }

        button[type="submit"],
        .success-message {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .success-message {
            margin-top: 20px;
            padding: 10px;
            background-color: #dff0d8;
            color: #3c763d;
            border-radius: 5px;
        }

        .login-button {
            display: block;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php if ($message !== ''): ?>
        <?php if ($message === 'Password updated successfully.'): ?>
            <div class="success-message"><?php echo $message; ?></div>
            <div class="login-button">
                <button onclick="location.href='index.php'">Go to Login</button>
            </div>
        <?php else: ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    <?php else: ?>
        <form action="update_password.php" method="POST">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="hidden" name="token" value="<?php echo $token; ?>">
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
    <?php endif; ?>
</body>
</html>

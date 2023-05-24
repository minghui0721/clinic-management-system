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
?>
            <!DOCTYPE html>
            <html>

            <head>
                <title>Password Reset</title>
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

                    button[type="submit"] {
                        padding: 10px 20px;
                        background-color: #4CAF50;
                        color: #fff;
                        border: none;
                        cursor: pointer;
                    }
                </style>
            </head>

            <body>
                <h1>Password Reset</h1>
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
            </body>

            </html>
<?php
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

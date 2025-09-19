<?php
session_start();
include 'connection.php';

$errorGeneral = '';
$successMessage = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Validate the token
    if ($stmt = $conn->prepare("SELECT email, expires FROM password_resets WHERE token = ? AND expires > NOW()")) {
        $stmt->bind_param('s', $token);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res && $res->num_rows === 1) {
            $resetRequest = $res->fetch_assoc();
            $email = $resetRequest['email'];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $password = $_POST['password'] ?? '';
                $confirmPassword = $_POST['confirm_password'] ?? '';

                if ($password !== $confirmPassword) {
                    $errorGeneral = 'Passwords do not match.';
                } elseif (strlen($password) < 8) {
                    $errorGeneral = 'Password must be at least 8 characters long.';
                } else {
                    // Hash the new password
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                    // Update the user's password
                    if ($stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?")) {
                        $stmt->bind_param('ss', $hashedPassword, $email);
                        $stmt->execute();

                        // Delete the reset token
                        if ($stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?")) {
                            $stmt->bind_param('s', $token);
                            $stmt->execute();
                        }

                        $successMessage = 'Your password has been successfully reset.';
                    } else {
                        $errorGeneral = 'Database error. Please try again later.';
                    }
                }
            }
        } else {
            $errorGeneral = 'Invalid or expired reset link.';
        }
        $stmt->close();
    } else {
        $errorGeneral = 'Database error. Please try again later.';
    }
} else {
    $errorGeneral = 'No reset token provided.';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | VSoft</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Reset Password</h2>
        <?php if ($errorGeneral): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorGeneral) ?></div>
        <?php endif; ?>
        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class
::contentReference[oaicite:1]{index=1}="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
    </div>
</body>
</html>     

 

<?php
// public/password_reset_request.php

session_start();
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../config/mail.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $errors = [];

    if (!$email) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (empty($errors)) {
        // Check if user exists
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            // Create token
            $token = bin2hex(random_bytes(32)); // secure random token
            $token_hash = password_hash($token, PASSWORD_DEFAULT);
            $expires_at = date('Y-m-d H:i:s', time() + 3600); // expires in 1 hour

            // Insert into password_resets
            $stmt_ins = $mysqli->prepare("INSERT INTO password_resets (email, token_hash, created_at, expires_at) VALUES (?, ?, NOW(), ?)");
            $stmt_ins->bind_param("sss", $email, $token_hash, $expires_at);
            $stmt_ins->execute();
            $stmt_ins->close();

            // Send email with reset link
            $reset_link = "https://your-domain.com/password_reset.php?email=" . urlencode($email) . "&token=" . urlencode($token);
            $subject = "Password Reset Request";
            $bodyHtml = "<p>We received a password reset request for your account.</p>"
                      . "<p>If you did not request this, you can ignore this email.</p>"
                      . "<p>Otherwise, <a href='$reset_link'>click here to reset your password</a>. This link is valid for 1 hour.</p>";
            sendMail($email, $subject, $bodyHtml);

            $_SESSION['message'] = "If an account with that email exists, a reset link has been sent.";
            header('Location: login.php');
            exit;
        } else {
            // For security, don't reveal that user doesn't exist
            $_SESSION['message'] = "If an account with that email exists, a reset link has been sent.";
            header('Location: login.php');
            exit;
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html>
<head><title>Reset Password</title></head>
<body>
<?php
if (!empty($errors)) {
    echo '<ul>';
    foreach ($errors as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo '</ul>';
}
?>

<form action="password_reset_request.php" method="post">
    Enter your email: <input type="email" name="email" value="<?=htmlspecialchars($email ?? '')?>"><br>
    <input type="submit" value="Send Reset Link">
</form>
</body>
</html>

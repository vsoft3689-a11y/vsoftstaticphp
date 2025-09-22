<?php
// public/password_reset.php

session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $email = $_GET['email'] ?? '';
    $token = $_GET['token'] ?? '';
    // Show form only if these are present
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $token = $_POST['token'] ?? '';
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $errors = [];

    if (!$email || !$token) {
        $errors[] = "Invalid request.";
    }
    if (!$password) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if ($password !== $password_confirm) {
        $errors[] = "Password confirmation does not match.";
    }

    if (empty($errors)) {
        // Lookup reset token row
        $stmt = $mysqli->prepare("SELECT token_hash, expires_at FROM password_resets WHERE email = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($token_hash, $expires_at);
            $stmt->fetch();
            $stmt->close();

            // check expiry
            if (new DateTime() > new DateTime($expires_at)) {
                $errors[] = "Reset link has expired.";
            } elseif (!password_verify($token, $token_hash)) {
                $errors[] = "Invalid token.";
            } else {
                // Everything OK -> update user password
                $new_hash = password_hash($password, PASSWORD_DEFAULT);
                $stmt2 = $mysqli->prepare("UPDATE users SET password_hash = ?, updated_at = NOW() WHERE email = ?");
                $stmt2->bind_param("ss", $new_hash, $email);
                $stmt2->execute();
                $stmt2->close();

                // Optionally, clear/reset any existing remember_token or sessions if needed

                // Delete reset entries for that email (or mark used)
                $stmt3 = $mysqli->prepare("DELETE FROM password_resets WHERE email = ?");
                $stmt3->bind_param("s", $email);
                $stmt3->execute();
                $stmt3->close();

                $_SESSION['success'] = "Password has been reset. You can now login.";
                header('Location: login.php');
                exit;
            }
        } else {
            $errors[] = "Invalid request.";
        }
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

<form action="password_reset.php" method="post">
    <input type="hidden" name="email" value="<?=htmlspecialchars($email)?>">
    <input type="hidden" name="token" value="<?=htmlspecialchars($token)?>">

    New Password: <input type="password" name="password"><br>
    Confirm Password: <input type="password" name="password_confirm"><br>
    <input type="submit" value="Reset Password">
</form>
</body>
</html>

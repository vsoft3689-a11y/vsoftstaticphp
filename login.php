<?php
// public/login.php

session_start();
include "./config/database.php" ;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $errors = [];

    if (!$email || !$password) {
        $errors[] = "Email and Password are required.";
    } else {
        // Fetch user
        $stmt = $conn->prepare("SELECT id, name, password_hash, email_verified_at FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $name, $password_hash, $email_verified_at);
            $stmt->fetch();
            if (!password_verify($password, $password_hash)) {
                $errors[] = "Invalid credentials.";
            } else {
                // Optional: check if email is verified
                if (is_null($email_verified_at)) {
                    $errors[] = "Please verify your email first.";
                } else {
                    // Login successful
                    $_SESSION['user_id'] = $id;
                    $_SESSION['user_name'] = $name;
                    // Optionally: set a remember_token cookie if “remember me” feature
                    header('Location: dashboard.php');
                    exit;
                }
            }
        } else {
            $errors[] = "Invalid credentials.";
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
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

<form action="login.php" method="post">
    Email: <input type="email" name="email" value="<?=htmlspecialchars($email ?? '')?>"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>

<p><a href="password_reset_request.php">Forgot password?</a></p>
</body>
</html>

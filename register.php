<?php
// public/register.php

session_start();
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Get & sanitize inputs
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $phone   = trim($_POST['phone'] ?? '');
    $college = trim($_POST['college'] ?? '');
    $branch  = trim($_POST['branch'] ?? '');
    $year    = trim($_POST['year'] ?? '');

    $errors = [];

    // Validation
    if (!$name) {
        $errors[] = "Name is required.";
    }
    if (!$email) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (!$password) {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters.";
    }
    if ($password !== $password_confirm) {
        $errors[] = "Password confirmation does not match.";
    }
    // … you can add more rules for phone, college, branch, year

    if (empty($errors)) {
        // Check if email already exists
        $stmt = $mysqli->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "A user with that email already exists.";
        }
        $stmt->close();
    }

    if (empty($errors)) {
        // Hash password
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insert user
        $stmt = $mysqli->prepare(
            "INSERT INTO users (name, email, password_hash, phone, college, branch, year_of_study) VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("sssssss", $name, $email, $password_hash, $phone, $college, $branch, $year);
        if ($stmt->execute()) {
            // Optionally send email verification link
            // generate a verification token or just send link with user id & hash

            $_SESSION['success'] = "Registration successful. Please verify your email.";
            header('Location: login.php');
            exit;
        } else {
            $errors[] = "Database insertion failed: " . $mysqli->error;
        }
        $stmt->close();
    }
}

?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
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

<form action="register.php" method="post">
    Name: <input type="text" name="name" value="<?=htmlspecialchars($name ?? '')?>"><br>
    Email: <input type="email" name="email" value="<?=htmlspecialchars($email ?? '')?>"><br>
    Password: <input type="password" name="password"><br>
    Confirm Password: <input type="password" name="password_confirm"><br>
    Phone: <input type="text" name="phone" value="<?=htmlspecialchars($phone ?? '')?>"><br>
    College: <input type="text" name="college" value="<?=htmlspecialchars($college ?? '')?>"><br>
    Branch: <input type="text" name="branch" value="<?=htmlspecialchars($branch ?? '')?>"><br>
    Year of Study: <input type="text" name="year" value="<?=htmlspecialchars($year ?? '')?>"><br>

    <input type="submit" value="Register">
</form>
</body>
</html>
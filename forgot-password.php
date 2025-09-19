<?php
session_start();
include 'connection.php';

$errorEmail = '';
$errorGeneral = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if ($email === '') {
        $errorEmail = 'Please enter your email address.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorEmail = 'Please enter a valid email address.';
    } else {
        // prepare statement
        $stmt = $conn->prepare("SELECT id, name FROM users WHERE email = ?");
        if ($stmt !== false) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && $res->num_rows === 1) {
                $user = $res->fetch_assoc();
                // generate token, send mail etc
            } else {
                $errorGeneral = 'No account found with that email address.';
            }
            $stmt->close();
        } else {
            $errorGeneral = 'Database error: ' . htmlspecialchars($conn->error);
        }
    }
}

// (rest of HTML etc.)
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password | VSoft</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2 class="mt-5">Forgot Password</h2>
        <?php if ($errorGeneral): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($errorGeneral) ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" name="email" id="email" class="form-control <?= ($errorEmail ? 'is-invalid' : '') ?>" placeholder="name@example.com" value="<?= htmlspecialchars($email ?? '') ?>">
                <?php if ($errorEmail): ?>
                    <div class="invalid-feedback"><?= htmlspecialchars($errorEmail) ?></div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Send Reset Link</button>
        </form>
    </div>
</body>
</html>

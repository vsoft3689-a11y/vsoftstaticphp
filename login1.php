<?php
session_start();
include 'connection1.php';

$email = $_SESSION['registered_email'] ?? '';
$success_msg = $_SESSION['success_msg'] ?? '';
$login_error = '';

// Clear session after reading
unset($_SESSION['registered_email'], $_SESSION['registered_pass'], $_SESSION['success_msg']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $login_error = "Please enter both email and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, password, name FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hashed_password, $user_name);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $user_name;
                echo "<script>alert('Login successful!'); window.location.href='dashboard.php';</script>";
                exit();
            } else {
                $login_error = "Incorrect password.";
            }
        } else {
            $login_error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login | VSoft</title>
    <link href="css/style.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet"> 
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>


    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Page theme overrides (match register1.php) -->
    <style>
        :root { --primary: #06bbcc; }
        .login-form h2 { color: var(--primary); }
        .login-form .form-control:focus { box-shadow: 0 0 10px rgba(6, 187, 204, 0.25); border-color: var(--primary); }
        .login-form label { color: #06bbcc; }
        .login-form .btn-primary { background-color: #06bbcc; border-color: #06bbcc; }
        .login-form .btn-primary:hover { background-color: #05a4b3; border-color: #05a4b3; }
        .login-form a { color: #06bbcc; }
        .login-form a:hover { color: #05a4b3; }
    </style>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
</head>
    <body>
    <?php include 'navbar.php'; ?>

    <div class="login-wrapper">
    <div class="login-form">
        <h2>Login</h2>

        <?php if ($success_msg): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success_msg) ?></div>
        <?php endif; ?>

        <?php if ($login_error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($login_error) ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" class="form-control" required>
                <div class="invalid-feedback">Please enter your email.</div>
            </div>
            <div class="mb-3">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <div class="invalid-feedback">Please enter your password.</div>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>

            <div class="text-center mt-3">
                <a href="forgotpassword1.php">Forgot Password?</a> |
                <a href="register1.php">Register Here</a>
            </div>
        </form>
    </div>
        <?php include 'footer.php'; ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
    // Bootstrap-style form validation
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        this.classList.add('was-validated');
    });
</script>
</body>
</html>
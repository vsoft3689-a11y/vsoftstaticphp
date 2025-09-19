<?php
session_start();
// Prevent caching to avoid using back button to revisit steps
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
include 'connection1.php';

$step = 1;
$error = '';
$success = '';
$confirm_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['send_otp'])) {
        $email = trim($_POST['email']);
        $_SESSION['reset_email'] = $email;

        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $error = "Email not found.";
        } else {
            // Generate OTP
            $otp = rand(100000, 999999);

            // Remove previous OTPs for this email (optional cleanup)
            $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $del->bind_param('s', $email);
            $del->execute();

            // Insert OTP into DB
            $insert = $conn->prepare("INSERT INTO password_resets (email, otp) VALUES (?, ?)");
            $insert->bind_param('ss', $email, $otp);
            if ($insert->execute()) {
                $_SESSION['sent_otp'] = $otp; // store OTP in session for testing (remove in production)
                $step = 2;
                $success = "OTP sent successfully! (For testing only: $otp)";
            } else {
                $error = "Error sending OTP: " . $conn->error;
            }
        }
        $stmt->close();
    }

    elseif (isset($_POST['verify_otp'])) {
        $entered_otp = trim($_POST['otp']);
        $email = $_SESSION['reset_email'] ?? '';

        if (!$email) {
            $error = "Session expired. Please try again.";
        } else {
            // Check OTP validity and expiry (optional: add expiry logic)
            $check = $conn->prepare("SELECT id FROM password_resets WHERE email = ? AND otp = ? ORDER BY created_at DESC LIMIT 1");
            $check->bind_param('ss', $email, $entered_otp);
            $check->execute();
            $check->store_result();

            if ($check->num_rows === 1) {
                $step = 3; // proceed to reset password
                $_SESSION['otp_verified'] = true;
                $success = "OTP verified. Please enter your new password.";
            } else {
                $error = "Invalid OTP. Please try again.";
                $step = 2;
            }
            $check->close();
        }
    }

    elseif (isset($_POST['reset_password'])) {
        $new_pass = $_POST['new_password'] ?? '';
        $confirm_pass = $_POST['confirm_password'] ?? '';
        $email = $_SESSION['reset_email'] ?? '';

        if (!$email || empty($_SESSION['otp_verified'])) {
            $error = "Session expired. Please try again.";
            $step = 1;
        } elseif ($new_pass !== $confirm_pass) {
            $confirm_error = "Please enter the same password in both fields.";
            $step = 3;
        } elseif (strlen($new_pass) < 8) {
            $error = "Password must be at least 8 characters long.";
            $step = 3;
        } else {
            $hashed = password_hash($new_pass, PASSWORD_DEFAULT);

            $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update->bind_param('ss', $hashed, $email);
            if ($update->execute()) {
                // Cleanup OTPs after reset
                $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
                $del->bind_param('s', $email);
                $del->execute();

                session_destroy();
                echo "<script>alert('Password reset successful! Please login.'); window.location.href='login.php';</script>";
                exit();
            } else {
                $error = "Error updating password: " . $conn->error;
            }
            $update->close();
        }
    }
}
if (isset($_POST['send_otp'])) {
    $email = trim($_POST['email']);
    $_SESSION['reset_email'] = $email;

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $error = "Email not found.";
    } else {
        // Generate OTP
        $otp = rand(100000, 999999);

        // Send via email
        require 'vendor/autoload.php';
        $sent = sendOtpEmail($email, $otp);   // using the PHPMailer function defined earlier

        if ($sent) {
            // Remove previous OTPs
            $del = $conn->prepare("DELETE FROM password_resets WHERE email = ?");
            $del->bind_param('s', $email);
            $del->execute();

            // Insert OTP into DB
            $insert = $conn->prepare("INSERT INTO password_resets (email, otp, created_at) VALUES (?, ?, NOW())");
            $insert->bind_param('ss', $email, $otp);
            if ($insert->execute()) {
                $_SESSION['sent_otp'] = $otp; // (optional, testing only)
                $step = 2;
                $success = "OTP sent successfully to your email!";
            } else {
                $error = "Error saving OTP: " . $conn->error;
            }
            $insert->close();
        } else {
            $error = "Failed to send OTP email. Please check your email configuration.";
        }
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Forgot Password | VSoft</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        :root { --primary: #06bbcc; }
        body { background-color: #f4f4f4; font-family: 'Nunito', sans-serif; }
        .form-box {
            max-width: 500px;
            margin: 80px auto;
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .form-box h2 { 
            color: var(--primary); 
            font-weight: 700; 
            margin-bottom: 20px; 
        }
        .form-box .form-control { 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
            transition: all 0.3s ease; 
        }
        .form-box .form-control:focus { 
            box-shadow: 0 0 10px rgba(6, 187, 204, 0.25); 
            border-color: var(--primary); 
        }
        .form-box label { color: #06bbcc; font-weight: 500; }
        .form-box .btn { 
            border-radius: 8px; 
            padding: 12px; 
            font-weight: 600; 
        }
        .form-box .btn-info { 
            background-color: #06bbcc; 
            border-color: #06bbcc; 
        }
        .form-box .btn-info:hover { 
            background-color: #05a4b3; 
            border-color: #05a4b3; 
        }
        .form-box .btn-success { 
            background-color: #28a745; 
            border-color: #28a745; 
        }
        .form-box .btn-warning { 
            background-color: #ffc107; 
            border-color: #ffc107; 
            color: #000; 
        }
        .form-box a { color: #06bbcc; }
        .form-box a:hover { color: #05a4b3; }
    </style>
</head>
<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Start -->
    <?php include 'navbar.php'; ?>
    <!-- Navbar End -->

<div class="form-box">
    <h2 class="mb-4">Forgot Password</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <?php if ($step === 1): ?>
        <form method="post" id="emailForm" novalidate>
            <div class="mb-3">
                <label>Enter Your Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
                <div class="invalid-feedback">Please enter your email address.</div>
            </div>
            <button type="submit" name="send_otp" class="btn btn-info w-100">Send OTP</button>
        </form>

    <?php elseif ($step === 2): ?>
        <form method="post" id="otpForm" novalidate>
            <div class="mb-3">
                <label>Enter OTP</label>
                <input type="text" name="otp" class="form-control" required autofocus>
                <div class="invalid-feedback">Please enter the OTP.</div>
            </div>
            <button type="submit" name="verify_otp" class="btn btn-success w-100">Verify OTP</button>
        </form>

    <?php elseif ($step === 3): ?>
        <form method="post" id="passwordForm" novalidate>
            <div class="mb-3">
                <label>Enter New Password</label>
                <input type="password" name="new_password" class="form-control" required autofocus>
                <div class="invalid-feedback">Please enter your new password.</div>
            </div>
            <div class="mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control <?= ($confirm_error ? 'is-invalid' : '') ?>" required>
                <div class="invalid-feedback">
                    <?= $confirm_error ? htmlspecialchars($confirm_error) : 'Please confirm your new password.' ?>
                </div>
            </div>
            <button type="submit" name="reset_password" class="btn btn-warning w-100">Reset Password</button>
        </form>
    <?php endif; ?>

    <div class="text-center mt-3">
        <a href="login.php">Back to Login</a>
    </div>
</div>

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->

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
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(e) {
                if (!this.checkValidity()) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                this.classList.add('was-validated');
            });
        });
    </script>

</body>
</html>
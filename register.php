<?php
session_start();
include 'connection1.php';

$error = '';
$success = '';
$name = $email = $password = $phone = $college = $branch = $year = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $college = trim($_POST['college'] ?? '');
    $branch = trim($_POST['branch'] ?? '');
    $year = trim($_POST['year'] ?? '');

    if ($name === '' || $email === '' || $password === '' || $phone === '' || $college === '' || $branch === '' || $year === '') {
        $error = 'Please fill all the fields.';
    } elseif (!preg_match('/^\d{10}$/', $phone)) {
        $error = 'Phone number must be exactly 10 digits.';
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = 'User already exists with this email.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO users (name, email, password, phone, college, branch, year) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $ins->bind_param('sssssss', $name, $email, $hashed, $phone, $college, $branch, $year);
            if ($ins->execute()) {
                $_SESSION['registered_email'] = $email;
                $_SESSION['registered_pass'] = $password;
                $_SESSION['success_msg'] = 'Registration successful!';

                echo "<script>alert('Registration successful! Redirecting to login...'); window.location.href='login.php';</script>";
                exit();
            } else {
                $error = 'Database error: ' . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register | VSoft</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <!-- Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Fonts -->
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
    <link href="css/register.css" rel="stylesheet">


    <!-- Page theme overrides -->
    <style>
        :root { --primary: #06bbcc; }
        body { background: #f4f4f4; font-family: 'Nunito', sans-serif; }
        .register-form { 
            max-width: 600px; 
            margin: 50px auto; 
            background: #fff; 
            padding: 30px; 
            border-radius: 15px; 
            box-shadow: 0 0 20px rgba(0,0,0,0.1); 
        }
        .register-form h2 { 
            margin-bottom: 20px; 
            font-weight: 700; 
            color: var(--primary); 
        }
        .register-form .form-control { 
            border-radius: 8px; 
            border: 2px solid #e0e0e0; 
            transition: all 0.3s ease; 
        }
        .register-form .form-control:focus { 
            box-shadow: 0 0 10px rgba(6, 187, 204, 0.25); 
            border-color: var(--primary); 
            border-radius: 8px; 
        }
        .register-form label { color: #06bbcc; font-weight: 500; }
        .register-form .btn-primary { 
            background-color: #06bbcc; 
            border-color: #06bbcc; 
            border-radius: 8px; 
            padding: 12px; 
            font-weight: 600; 
        }
        .register-form .btn-primary:hover { 
            background-color: #05a4b3; 
            border-color: #05a4b3; 
            transform: translateY(-1px); 
        }
        .register-form a { color: #06bbcc; }
        .register-form a:hover { color: #05a4b3; }
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

<div class="register-form">
    <h2 class="text-center">Student Registration</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" id="registerForm" novalidate>
        <div class="mb-3"><label>Full Name</label>
            <input type="text" name="name" value="<?= htmlspecialchars($name) ?>" class="form-control" required>
            <div class="invalid-feedback">Please enter your full name.</div>
        </div>
        <div class="mb-3"><label>Email</label>
            <input type="email" name="email" value="<?= htmlspecialchars($email) ?>" class="form-control" required>
            <div class="invalid-feedback">Please enter a valid email.</div>
        </div>
        <div class="mb-3"><label>Password</label>
            <input type="password" name="password" class="form-control" required>
            <div class="invalid-feedback">Please enter your password.</div>
        </div>
        <div class="mb-3"><label>Phone</label>
            <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>" class="form-control" required pattern="\d{10}" maxlength="10">
            <div class="invalid-feedback">Please enter a 10-digit phone number.</div>
        </div>
        <div class="mb-3"><label>College / University</label>
            <input type="text" name="college" value="<?= htmlspecialchars($college) ?>" class="form-control" required>
            <div class="invalid-feedback">Please enter your college or university.</div>
        </div>
        <div class="mb-3"><label>Branch</label>
            <input type="text" name="branch" value="<?= htmlspecialchars($branch) ?>" class="form-control" required>
            <div class="invalid-feedback">Please enter your branch.</div>
        </div>
        <div class="mb-3"><label>Year of Study</label>
            <select name="year" class="form-control" required>
                <option value="">Select</option>
                <option <?= $year === '1' ? 'selected' : '' ?> value="1">1st Year</option>
                <option <?= $year === '2' ? 'selected' : '' ?> value="2">2nd Year</option>
                <option <?= $year === '3' ? 'selected' : '' ?> value="3">3rd Year</option>
                <option <?= $year === '4' ? 'selected' : '' ?> value="4">4th Year</option>
            </select>
            <div class="invalid-feedback">Please select your year of study.</div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
        <div class="text-center mt-3">
            Already registered? <a href="login.php">Login here</a>
        </div>
    </form>
</div>

    <!-- Footer Start -->
    <?php include 'footer.php'; ?>
    <!-- Footer End -->

    <!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

<!-- JS Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>

<script>
// Bootstrap-style inline validation (like login.php)
document.getElementById('registerForm').addEventListener('submit', function(e) {
    if (!this.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
    }
    this.classList.add('was-validated');
});
</script>

</body>
</html>
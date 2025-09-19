<?php
session_start();
include 'connection1.php';

$email = $_SESSION['registered_email'] ?? '';
$success_msg = $_SESSION['success_msg'] ?? '';
$login_error = '';

// Clear session flash after reading
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
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Login | VSoft</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Your external CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">

    <!-- Libraries -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Custom theme overrides -->
    <style>
        :root {
            --primary: #06bbcc;
        }

        body {
            font-family: 'Heebo', sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-container {
            flex: 1;
        }

        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 15px;
        }

        .login-form {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .login-form h2 {
            color: var(--primary);
            margin-bottom: 30px;
            text-align: center;
        }

        .login-form label {
            color: var(--primary);
        }

        .login-form .form-control:focus {
            box-shadow: 0 0 10px rgba(6, 187, 204, 0.25);
            border-color: var(--primary);
        }

        .login-form .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .login-form .btn-primary:hover {
            background-color: #05a4b3;
            border-color: #05a4b3;
        }

        .login-form a {
            color: var(--primary);
        }

        .login-form a:hover {
            color: #05a4b3;
        }

        /* Navbar tweaks */
        .navbar-custom {
            background-color: #ffffff; /* white bg for navbar */
        }
        .navbar-custom .nav-item .nav-link {
            color: var(--primary);
        }
        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #05a4b3; /* a slightly darker shade on hover / active */
        }
        .navbar-custom .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        /* Footer theme */
        .footer-custom {
            background-color: #333; /* dark bg for footer */
            color: #fff;
        }
        .footer-custom .footer a.btn-link {
            color: #06bbcc;
        }
        .footer-custom .footer a.btn-link:hover {
            color: #05a4b3;
        }
        .footer-custom .footer h4 {
            color: #ffffff;
        }
        .footer-custom .btn-outline-light.btn-social i {
            color: #ffffff;
        }
        .footer-custom .copyright a {
            color: var(--primary);
        }
    </style>

</head>
<body>

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0 navbar-custom">
        <a href="index.php" class="navbar-logo px-4 px-lg-5">
            <img src="img/logo.webp"
                alt="VSoft Solutions Pvt Ltd Logo"
                style="height:48px; width:auto; display:block; object-fit:contain;" />
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link">About</a>
                <a href="services.php" class="nav-item nav-link">Services</a>
                <a href="projects.php" class="nav-item nav-link">Projects</a>
                <a href="internship.php" class="nav-item nav-link">Internship</a>
                <a href="contact.php" class="nav-item nav-link">Contact</a>
            </div>
            <a href="login1.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now <i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
    <!-- Navbar End -->

    <div class="content-container">
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
                        <input type="email" id="email" name="email"
                               value="<?= htmlspecialchars($email) ?>"
                               class="form-control" required>
                        <div class="invalid-feedback">Please enter your email.</div>
                    </div>
                    <div class="mb-3">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password"
                               class="form-control" required>
                        <div class="invalid-feedback">Please enter your password.</div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    <div class="text-center mt-3">
                        <a href="forgotpassword1.php">Forgot Password?</a> |
                        <a href="register1.php">Register Here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn footer-custom" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="about.php">About Us</a>
                    <a class="btn btn-link" href="contact.php">Contact Us</a>
                    <a class="btn btn-link" href="privacypolicy.php">Privacy Policy</a>
                    <a class="btn btn-link" href="terms.php">Terms & Condition</a>
                    <a class="btn btn-link" href="faq.php">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Survey No. 64, Madhapur</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+91-9441927859</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@vsoftssolutions.in</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social me-1" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social me-1" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social me-1" href="#"><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Gallery</h4>
                    <div class="row g-2 pt-2">
                        <div class="col-4">
                            <a href="img/major1.jpg"><img class="img-fluid bg-light p-1" src="img/major1.jpg" alt=""></a>
                        </div>
                        <div class="col-4">
                            <a href="img/mini1.jpg"><img class="img-fluid bg-light p-1" src="img/mini1.jpg" alt=""></a>
                        </div>
                        <div class="col-4">
                            <a href="img/sathInternshp.jpg"><img class="img-fluid bg-light p-1" src="img/sathInternshp.jpg" alt=""></a>
                        </div>
                        <div class="col-4">
                            <a href="img/sathvikacyber.jpg"><img class="img-fluid bg-light p-1" src="img/sathvikacyber.jpg" alt=""></a>
                        </div>
                        <div class="col-4">
                            <a href="img/sathStructural.jpg"><img class="img-fluid bg-light p-1" src="img/sathStructural.jpg" alt=""></a>
                        </div>
                        <div class="col-4">
                            <a href="img/mini1.jpg"><img class="img-fluid bg-light p-1" src="img/mini1.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Subscribe to our Newsletter for Updates</h4>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-info py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright py-4">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">VSofts Solutions</a>, All Rights Reserved.
                        <br>
                        Designed By <a class="border-bottom" href="https://westechnologies.in">westechnologies.in</a>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="index.php">Home</a>
                            <a href="contact.php">Help</a>
                            <a href="faq.php">FAQs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <script src="js/main.js"></script>

    <script>
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

<?php
session_start();
include 'connection.php';

$errorEmail = '';
$errorPassword = '';
$errorGeneral = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '') {
        $errorEmail = 'Please enter the email.';
    }
    if ($password === '') {
        $errorPassword = 'Please enter the password.';
    }

    // If both are non-empty, then only try to check credentials
    if ($errorEmail === '' && $errorPassword === '') {
        if ($stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?")) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res && $res->num_rows === 1) {
                $user = $res->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user'] = [
                        'id' => $user['id'],
                        'name' => $user['name']
                    ];
                    header('Location: 5Dashboard.php');
                    exit();
                } else {
                    $errorGeneral = 'Invalid credentials.';
                }
            } else {
                $errorGeneral = 'Invalid credentials.';
            }
            $stmt->close();
        } else {
            $errorGeneral = 'Database error.';
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login | VSoft</title>
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

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
 
  <!-- your head content: CSS, favicon etc. -->
  <!-- your head -->

</head>
<body>
  <!-- Navbar Start -->
         <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="navbarP.html" class="navbar-logo">
      <img src="./img/logo.webp"
        alt="VSoft Solutions Pvt Ltd Logo" style="height:48px; width:auto; display:block; object-fit:contain;" />
    </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="./index.php" class="nav-item nav-link">Home</a>
                <a href="./about.php" class="nav-item nav-link">About</a>
                <a href="./services.php" class="nav-item nav-link">Services</a>
                <a href="./projects.php" class="nav-item nav-link">Projects</a>
                <a href="./internship.php" class="nav-item nav-link">Internship</a>
                <a href="./contact.php" class="nav-item nav-link">Contact</a>
            </div>
            <a href="./login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a>
        </div>
    </nav>
  <!-- navbar etc. -->

  <div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card p-4 shadow" style="max-width: 380px; width: 100%; border: 2px solid #06bbcc;">
    <h4 class="text-center mb-4">Login to VSoft</h4>

    <?php if ($errorGeneral): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($errorGeneral) ?></div>
      <?php endif; ?>

      <form method="post" action="">
        <div class="mb-3" style="border-radius: 10px;">
        <label for="email" style="color: #06bbcc;"> Email address</label>  
        <input type="email"
                 name="email"
                 id="email"
                 class="form-control <?= ($errorEmail ? 'is-invalid' : '') ?>"
                 placeholder="name@example.com"
                 value="<?= htmlspecialchars($email ?? '') ?>">
          
          <?php if ($errorEmail): ?>
            <div class="invalid-feedback">
              <?= htmlspecialchars($errorEmail) ?>
            </div>
          <?php endif; ?>
        </div>

        <div class="mb-3">
          <label for="password" style="color: #06bbcc;"> Password</label>
          <input type="password"
                 name="password"
                 id="password"
                 class="form-control <?= ($errorPassword ? 'is-invalid' : '') ?>"
                 placeholder="Password">
          
          <?php if ($errorPassword): ?>
            <div class="invalid-feedback">
              <?= htmlspecialchars($errorPassword) ?>
            </div>
          <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <p class="text-center mt-3">Don't have an account? <a href="./register.php" class="link-primary">Register here</a></p>
      </form>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Back to Top
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
    <!-- Footer Start -->
    
    <?php include 'footer.php'; ?>

    <!-- Footer End -->
  <!-- scripts etc. -->


  <!-- scripts / footer etc. -->
   <script>
    (function () {
      'use strict';
      var forms = document.querySelectorAll('.needs-validation');
      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
    })();
  </script>
</body>
</html>

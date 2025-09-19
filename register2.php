<?php
session_start();
include 'connection.php';

$error = '';
$errorName = '';
$errorEmail = '';
$errorPassword = '';
$errorPhone = '';
$errorCollege = '';
$errorBranch = '';
$errorYear = '';
$success = '';

$name = '';
$email = '';
$phone = '';
$college = '';
$branch = '';
$year = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $college = trim($_POST['college'] ?? '');
    $branch = trim($_POST['branch'] ?? '');
    $year = trim($_POST['year'] ?? '');

    if ($name === '') {
        $errorName = 'Please enter the full name.';
    }
    if ($email === '') {
        $errorEmail = 'Please enter the email.';
    }
    if ($password === '') {
        $errorPassword = 'Please enter the password.';
    }
    if ($phone === '') {
        $errorPhone = 'Please enter the phone number.';
    }
    if ($college === '') {
        $errorCollege = 'Please enter the college/university.';
    }
    if ($branch === '') {
        $errorBranch = 'Please enter the branch.';
    }
    if ($year === '') {
        $errorYear = 'Please select the year of study.';
    }

    if ($errorName === '' && $errorEmail === '' && $errorPassword === '' && $errorPhone === '' && $errorCollege === '' && $errorBranch === '' && $errorYear === '') {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
            $stmt->close();
        } else {
            $stmt->close();
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $ins = $conn->prepare("INSERT INTO users (name, email, password, phone, college, branch, year) VALUES (?, ?, ?, ?, ?, ?, ?)");
            if ($ins === false) {
                $error = "Database error: " . htmlspecialchars($conn->error);
            } else {
                $ins->bind_param('sssssss', $name, $email, $hashed, $phone, $college, $branch, $year);
                if ($ins->execute()) {
                    $success = "Registration successful! Please login.";
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Database error: " . htmlspecialchars($conn->error);
                }
                $ins->close();
            }
        }
    } 
}
?>
<!DOCTYPE html>
<html>
<head>
  
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reistration | VSoft</title>
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
    <link href="css/register.css" rel="stylesheet">
 
  <!-- your head content: CSS, favicon etc. -->
  <!-- your head -->

</head>
    <!-- Your custom style overrides -->
    <!-- <style>
      body {
        background-color: #f0f9fa;
        font-family: 'Nunito', sans-serif;
      }

      /* Card with colored border */
      .card.custom-border {
        border: 2px solid #06bbcc;
        border-radius: 15px;
      }

      /* Inputs and select dropdown */
      .form-control,
      select.form-control {
        border: 2px solid #06bbcc;
        border-radius: 10px;
        transition: all 0.3s ease;
      }

      .form-control:focus,
      select.form-control:focus {
        border-color: #06bbcc;
        box-shadow: 0 0 5px rgba(6, 187, 204, 0.4);
        outline: none;
      }

      .form-control:hover,
      select.form-control:hover {
        background-color: #f8ffff;
        border-color: #0193a5;
      }

      .btn-primary {
        background-color: #06bbcc;
        border: none;
        border-radius: 10px;
        transition: background-color 0.3s ease, transform 0.2s ease;
        padding: 12px;
      }

      .btn-primary:hover {
        background-color: #0193a5;
        transform: scale(1.03);
        color: #fff;
      }

      .invalid-feedback {
        color: #e74c3c;
      }

      .alert-danger, .alert-success {
        border-radius: 10px;
      }

    </style> -->
</head>
<body>
  <!-- Navbar Start -->
  <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="navbarP.html" class="navbar-logo">
      <img src="./img/logo.webp"
           alt="VSoft Solutions Pvt Ltd Logo"
           style="height:48px; width:auto; display:block; object-fit:contain;" />
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
      <a href="./login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">
        Join Now<i class="fa fa-arrow-right ms-3"></i>
      </a>
    </div>
  </nav>
  <!-- Navbar End -->

  <div class="container py-5">
    <div class="card shadow mx-auto custom-border" style="max-width: 500px;">
      <div class="card-body">
        <h4 class="card-title text-center mb-4" style="color: #000;">Student Registration</h4>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
          <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="post" action="register.php" autocomplete="off">
          <div class="mb-3">
            <label class="form-label" style="color: #06bbcc;">Full Name</label>
            <input type="text" name="name"
                   class="form-control <?= $errorName ? 'is-invalid' : '' ?>"
                   value="<?= htmlspecialchars($name) ?>">
            <?php if ($errorName): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errorName) ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label" style="color: #06bbcc;">Email</label>
            <input type="email" name="email"
                   class="form-control <?= $errorEmail ? 'is-invalid' : '' ?>"
                   value="<?= htmlspecialchars($email) ?>">
            <?php if ($errorEmail): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errorEmail) ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label" style="color: #06bbcc;">Password</label>
            <input type="password" name="password"
                   class="form-control <?= $errorPassword ? 'is-invalid' : '' ?>">
            <?php if ($errorPassword): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errorPassword) ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label" style="color: #06bbcc;">Phone Number</label>
            <input type="text" name="phone"
                   class="form-control <?= $errorPhone ? 'is-invalid' : '' ?>"
                   value="<?= htmlspecialchars($phone) ?>">
            <?php if ($errorPhone): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errorPhone) ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label" style="color: #06bbcc;">College / University</label>
            <input type="text" name="college"
                   class="form-control <?= $errorCollege ? 'is-invalid' : '' ?>"
                   value="<?= htmlspecialchars($college) ?>">
            <?php if ($errorCollege): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errorCollege) ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label" style="color: #06bbcc;">Branch</label>
            <input type="text" name="branch"
                   class="form-control <?= $errorBranch ? 'is-invalid' : '' ?>"
                   value="<?= htmlspecialchars($branch) ?>">
            <?php if ($errorBranch): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errorBranch) ?></div>
            <?php endif; ?>
          </div>

          <div class="mb-3">
            <label class="form-label" style="color: #06bbcc;">Year Of Study</label>
            <select name="year"
                    class="form-control <?= $errorYear ? 'is-invalid' : '' ?>">
              <option value="" disabled <?= $year === '' ? 'selected' : '' ?>>-- Select Year --</option>
              <option value="1" <?= $year === '1' ? 'selected' : '' ?>>First Year</option>
              <option value="2" <?= $year === '2' ? 'selected' : '' ?>>Second Year</option>
              <option value="3" <?= $year === '3' ? 'selected' : '' ?>>Third Year</option>
              <option value="4" <?= $year === '4' ? 'selected' : '' ?>>Fourth Year</option>
            </select>
            <?php if ($errorYear): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errorYear) ?></div>
            <?php endif; ?>
          </div>

          <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="lib/animate/animate.min.js"></script>
  <script src="lib/owlcarousel/owl.carousel.min.js"></script>

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

<?php
session_start();
include 'connection1.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$success_msg = '';
$error_msg = '';

// Fetch user data
$stmt = $conn->prepare("SELECT name, email, phone, college, branch, year FROM users WHERE id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $college = trim($_POST['college'] ?? '');
    $branch = trim($_POST['branch'] ?? '');
    $year = trim($_POST['year'] ?? '');

    // Validation
    if ($name === '' || $email === '' || $phone === '' || $college === '' || $branch === '' || $year === '') {
        $error_msg = 'Please fill all the fields.';
    } elseif (!preg_match('/^\d{10}$/', $phone)) {
        $error_msg = 'Phone number must be exactly 10 digits.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = 'Please enter a valid email address.';
    } else {
        // Check if email is already taken by another user
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $check_stmt->bind_param('si', $email, $user_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $error_msg = 'Email is already taken by another user.';
        } else {
            // Update user data
            $update_stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, college = ?, branch = ?, year = ? WHERE id = ?");
            $update_stmt->bind_param('ssssssi', $name, $email, $phone, $college, $branch, $year, $user_id);
            
            if ($update_stmt->execute()) {
                $success_msg = 'Profile updated successfully!';
                // Update session data
                $_SESSION['user_name'] = $name;
                // Refresh user data
                $user = ['name' => $name, 'email' => $email, 'phone' => $phone, 'college' => $college, 'branch' => $branch, 'year' => $year];
            } else {
                $error_msg = 'Error updating profile: ' . $conn->error;
            }
            $update_stmt->close();
        }
        $check_stmt->close();
    }
}
?>

<?php
// Prevent viewing cached profile after logout
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile | VSoft</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root { --primary: #06bbcc; }
    .profile-pic {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid var(--primary);
    }
    .card-header { background-color: var(--primary) !important; }
    .form-control:focus { 
      border-color: var(--primary); 
      box-shadow: 0 0 10px rgba(6, 187, 204, 0.25); 
    }
    .form-label { color: var(--primary); font-weight: 500; }
    .btn-success { 
      background-color: var(--primary); 
      border-color: var(--primary); 
    }
    .btn-success:hover { 
      background-color: #05a4b3; 
      border-color: #05a4b3; 
    }
  </style>
  <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
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
</head>
<body class="bg-light">
       <!-- Navbar Start -->
     <?php include 'dashboard_nav.php'; ?>

     <!-- Navbar End -->

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <div class="card shadow-lg rounded-3">
          <div class="card-header text-white text-center">
            <h4>My Profile</h4>
          </div>
          <div class="card-body">

            <?php if ($success_msg): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success_msg) ?></div>
            <?php endif; ?>

            <?php if ($error_msg): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error_msg) ?></div>
            <?php endif; ?>

            <!-- Profile Form -->
            <form id="profileForm" method="POST" novalidate>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Full Name</label>
                  <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required>
                  <div class="invalid-feedback">Full name is required.</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required>
                  <div class="invalid-feedback">Please enter a valid email address.</div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Phone</label>
                  <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone'] ?? '') ?>" required pattern="^[0-9]{10}$" maxlength="10">
                  <div class="invalid-feedback">Enter a valid 10-digit phone number.</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">College</label>
                  <input type="text" name="college" class="form-control" value="<?= htmlspecialchars($user['college'] ?? '') ?>" required>
                  <div class="invalid-feedback">College name is required.</div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Branch</label>
                  <select name="branch" class="form-select" required>
                    <option value="" disabled>Select your branch</option>
                    <option value="CSE" <?= ($user['branch'] ?? '') === 'CSE' ? 'selected' : '' ?>>Computer Science (CSE)</option>
                    <option value="ECE" <?= ($user['branch'] ?? '') === 'ECE' ? 'selected' : '' ?>>Electronics (ECE)</option>
                    <option value="EEE" <?= ($user['branch'] ?? '') === 'EEE' ? 'selected' : '' ?>>Electrical (EEE)</option>
                    <option value="MECH" <?= ($user['branch'] ?? '') === 'MECH' ? 'selected' : '' ?>>Mechanical (MECH)</option>
                    <option value="CIVIL" <?= ($user['branch'] ?? '') === 'CIVIL' ? 'selected' : '' ?>>Civil (CIVIL)</option>
                    <option value="IT" <?= ($user['branch'] ?? '') === 'IT' ? 'selected' : '' ?>>Information Technology (IT)</option>
                    <option value="MBA" <?= ($user['branch'] ?? '') === 'MBA' ? 'selected' : '' ?>>Master of Business Administration (MBA)</option>
                    <option value="MCA" <?= ($user['branch'] ?? '') === 'MCA' ? 'selected' : '' ?>>Master of Computer Applications (MCA)</option>
                  </select>
                  <div class="invalid-feedback">Please select your branch.</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Year of Study</label>
                  <select name="year" class="form-select" required>
                    <option value="" disabled>Select your year</option>
                    <option value="1" <?= ($user['year'] ?? '') === '1' ? 'selected' : '' ?>>1st Year</option>
                    <option value="2" <?= ($user['year'] ?? '') === '2' ? 'selected' : '' ?>>2nd Year</option>
                    <option value="3" <?= ($user['year'] ?? '') === '3' ? 'selected' : '' ?>>3rd Year</option>
                    <option value="4" <?= ($user['year'] ?? '') === '4' ? 'selected' : '' ?>>4th Year</option>
                  </select>
                  <div class="invalid-feedback">Please select your year of study.</div>
                </div>
              </div>

              <!-- Save Button -->
              <div class="d-grid">
                <button type="submit" class="btn btn-success">Save Changes</button>
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Preview uploaded photo
    // function previewPhoto(event) {
    //   const reader = new FileReader();
    //   reader.onload = function(){
    //     document.getElementById("profilePic").src = reader.result;
    //   };
    //   reader.readAsDataURL(event.target.files[0]);
    // }

    // Bootstrap form validation
    const form = document.getElementById("profileForm");
    form.addEventListener("submit", function (event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add("was-validated");
    });
  </script>
   <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>

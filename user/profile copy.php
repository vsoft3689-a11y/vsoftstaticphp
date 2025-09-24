<?php
include '../config/database.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  $_SESSION['user_id'] = 1; // Temporary for testing; replace with real login session later
}

$conn = (new Database())->connect();
if ($conn->connect_error) {
  die(json_encode(["status" => "error", "message" => $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $degree = $_POST['degree'];
  $branch = $_POST['branch'];
  $domain = $_POST['domain'];
  $projectType = $_POST['project_type'] ?? '';

  $sql = "SELECT * FROM projects WHERE degree = ? AND branch = ? AND domain = ?";
  $params = [$degree, $branch, $domain];

  if (!empty($projectType)) {
    $sql .= " AND type = ?";
    $params[] = strtolower($projectType);
  }

  $stmt = $conn->prepare($sql);
  $stmt->bind_param(str_repeat("s", count($params)), ...$params);
  $stmt->execute();
  $result = $stmt->get_result();

  $_SESSION['project_results'] = $result->fetch_all(MYSQLI_ASSOC);

  header("Location: userprojects.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>User Project Selection</title>
  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
  <link href="../css/projects.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">
  <!-- Navbar Start -->
  <?php include 'user_navbar.php'; ?>
  <!-- Navbar End -->

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">

        <div class="card shadow-lg rounded-3">
          <div class="card-header text-white text-center">
            <h4>My Profile</h4>
          </div>
          <div class="card-body">

            <?php if (!empty($success_msg)): ?>
              <div class="alert alert-success"><?= htmlspecialchars($success_msg) ?></div>
            <?php endif; ?>

            <?php if (!empty($error_msg)): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($error_msg) ?></div>
            <?php endif; ?>

            <!-- Profile Form -->
            <form id="profileForm" method="POST" novalidate>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">Full Name</label>
                  <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name'] ?? '') ?>" required readonly>
                  <div class="invalid-feedback">Full name is required.</div>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required readonly>
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
                  <input type="text" class="form-control" value="<?= htmlspecialchars($user['branch'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label">Year of Study</label>
                  <input type="text" class="form-control" value="<?= htmlspecialchars($user['year'] ?? '') ?>" required>
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

  <!-- Footer Start -->
<?php include '../admin/footer.php'; ?>
  <!-- Footer End -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Bootstrap form validation
    const form = document.getElementById("profileForm");
    form.addEventListener("submit", function(event) {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add("was-validated");
    });
  </script>

  <!-- Back to Top -->
  <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>


  <!-- JavaScript Libraries -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../lib/wow/wow.min.js"></script>
  <script src="../lib/easing/easing.min.js"></script>
  <script src="../lib/waypoints/waypoints.min.js"></script>
  <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

  <!-- Template Javascript -->
  <script src="../js/main.js"></script>


  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Owl Carousel JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
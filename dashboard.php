<?php
session_start();

// header("Cache-Control: no-cache, no-store, must-revalidate");
// header("Pragma: no-cache");
// header("Expires: 0");

// Prevent viewing cached page after logout
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: 0');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    
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

    <div class="container mt-4">
        <!-- <h2 class="mb-4">Welcome to Your Dashboard</h2> -->
         <h2>Welcome, <?= htmlspecialchars($_SESSION['user_name']); ?></h2>
    <p>This is your dashboard page.</p>
        <div class="row">

            <!-- FR25: Profile -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-person-circle display-4 text-primary"></i>
                        <h5 class="card-title mt-3">My Profile</h5>
                        <p class="card-text">View and update your personal details.</p>
                        <a href="profile.php" class="btn btn-outline-primary btn-sm">Go to Profile</a>
                    </div>
                </div>
            </div>

            <!-- FR26: Submit Requirement -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-file-earmark-plus display-4 text-success"></i>
                        <h5 class="card-title mt-3">Submit Requirement</h5>
                        <p class="card-text">Submit your custom project requirement form.</p>
                        <a href="customreq.php" class="btn btn-outline-success btn-sm">Submit</a>
                    </div>
                </div>
            </div>

            <!-- FR27: Requirement Status -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-clipboard-check display-4 text-warning"></i>
                        <h5 class="card-title mt-3">Requirement Status</h5>
                        <p class="card-text">Track the status of your submitted requirements.</p>
                        <a href="reqstatus.php" class="btn btn-outline-warning btn-sm">View Status</a>
                    </div>
                </div>
            </div>

            <!-- FR28: Project History -->
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-clock-history display-4 text-danger"></i>
                        <h5 class="card-title mt-3">Project History</h5>
                        <p class="card-text">View all the projects you have shown interest in.</p>
                        <a href="projhistory.php" class="btn btn-outline-danger btn-sm">View History</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script>
    window.addEventListener('pageshow', function(event) {
      if (event.persisted || window.performance.navigation.type === 2) {
        // if page loaded from cache via back or forward
        window.location.href = 'index.php'; // or login page
      }
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

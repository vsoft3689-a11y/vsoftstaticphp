<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>VSoftSolutions user Panel</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="../img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="./admin_dashboard.php" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <!-- <h2 class="m-0 text-primary">VSoftSolutions</h2> -->
            <img src="../img/logo.webp"
                alt="VSoft Solutions Pvt Ltd Logo" style="height:48px; width:auto; display:block; object-fit:contain;" />
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="./user_dashboard.php" class="nav-item nav-link">Dashboard</a>
                <a href="./profile.php" class="nav-item nav-link">Profile</a>             
                <a href="./usercustomreq.php" class="nav-item nav-link">Custom Requirements</a>
                <a href="./userrequirementstatus.php" class="nav-item nav-link">Requirements status</a>
                
            </div>
            <!-- <a href="./login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Now<i class="fa fa-arrow-right ms-3"></i></a> -->
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'user'): ?>
                <!-- Show only when logged in -->
                <a href="../logout.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Logout</a>
            <?php else: ?>
                <!-- Show only when logged out -->
                <a href="../login.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Join Login</a>
            <?php endif; ?>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/wow/wow.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>

</html>
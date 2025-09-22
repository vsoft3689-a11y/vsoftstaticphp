<?php
session_start();
include 'connection1.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Project Requirements</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"> -->
  <meta charset="utf-8">
    <title>RequirementStatus</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

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
      <div class="col-md-10">
        <div class="card shadow-lg rounded-3">
          <div class="card-header bg-primary text-white text-center">
            <h4>Requirement Status</h4>
          </div>
          <div class="card-body">
            
            <table class="table table-hover align-middle">
              <thead class="table-dark">
                <tr>
                  <th>#</th>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Technologies</th>
                  <th>Document</th>
                  <th>Status</th>
                  <th>Submitted On</th>
                </tr>
              </thead>
              <tbody>
                <!-- Example row 1 -->
                <tr>
                  <td>1</td>
                  <td>AI Chatbot</td>
                  <td>Chatbot for answering FAQs</td>
                  <td>Python, NLP</td>
                  <td><a href="#" class="btn btn-sm btn-outline-primary">Download</a></td>
                  <td><span class="badge bg-warning">Pending</span></td>
                  <td>2025-09-07</td>
                </tr>

                <!-- Example row 2 -->
                <tr>
                  <td>2</td>
                  <td>Online Voting System</td>
                  <td>Secure voting platform</td>
                  <td>PHP, MySQL</td>
                  <td><a href="#" class="btn btn-sm btn-outline-primary">Download</a></td>
                  <td><span class="badge bg-success">Approved</span></td>
                  <td>2025-09-05</td>
                </tr>

                <!-- Example row 3 -->
                <tr>
                  <td>3</td>
                  <td>E-commerce App</td>
                  <td>Farm-to-Table network</td>
                  <td>React, Node.js</td>
                  <td><a href="#" class="btn btn-sm btn-outline-primary">Download</a></td>
                  <td><span class="badge bg-info">Done</span></td>
                  <td>2025-08-28</td>
                </tr>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
        <a href="./index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
            <h2 class="m-0 text-primary"><i class="fa fa-book me-3"></i>VsoftSolutions</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="./index.php" class="nav-item nav-link active">Home</a>
                <a href="./about.php" class="nav-item nav-link">About</a>
                <a href="./services.php" class="nav-item nav-link">Services</a>
                <a href="./projects.php" class="nav-item nav-link">Projects</a>
                <a href="./btech" class="nav-item nav-link">Internship</a>
                <a href="./contact.php" class="nav-item nav-link">Contact</a>
                <a href="./index.php" class=" btn btn-primary py-4 px-lg-5 d-none d-lg-block">Logout</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <div class="container-fluid mt-4">
        <div class="row">

            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="list-group">
                    <a href="#overview" class="list-group-item list-group-item-action active">Dashboard Overview</a>
                    <a href="#profile-edit" class="list-group-item list-group-item-action">View / Edit Profile</a>
                    <a href="#custom-requirement" class="list-group-item list-group-item-action">Submit Custom
                        Requirement</a>
                    <a href="#requirement-status" class="list-group-item list-group-item-action">My Requirement
                        Status</a>
                    <a href="#interested-projects" class="list-group-item list-group-item-action">Interested
                        Projects</a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">

                <!-- FR24: Dashboard overview -->
                <section id="overview" class="mb-5">
                    <h3>Dashboard Overview</h3>
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Custom Requirements</h5>
                                    <p class="card-text">5</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Under Review</h5>
                                    <p class="card-text">2</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Approved / Rejected</h5>
                                    <p class="card-text">3</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- FR25: View & Edit Profile -->
                <section id="profile-edit" class="mb-5">
                    <h3>My Profile</h3>
                    <form method="post" action="profile_update.php">
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="Surya Vardhan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="suryavardhan@example.com" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="9908887766">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">College / University</label>
                            <input type="text" name="college" class="form-control" value="Osmania University">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Branch</label>
                            <input type="text" name="branch" class="form-control" value="Computer Science">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Year of Study</label>
                            <select name="year" class="form-select">
                                <option value="1">First Year</option>
                                <option value="2" selected>Second Year</option>
                                <option value="3">Third Year</option>
                                <option value="4">Fourth Year</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Profile</button>
                    </form>
                </section>

                <!-- FR26: Submit Custom Requirement Form -->
                <section id="custom-requirement" class="mb-5">
                    <h3>Submit Custom Requirement</h3>
                    <form method="post" action="submit_requirement.php" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Project Title</label>
                            <input type="text" name="project_title" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Required Technologies</label>
                            <input type="text" name="technologies" class="form-control"
                                placeholder="e.g. PHP, React, MySQL" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Branch</label>
                            <input type="text" name="branch" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deadline</label>
                            <input type="date" name="deadline" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Upload Reference Documents</label>
                            <input type="file" name="reference_docs[]" class="form-control" multiple>
                        </div>
                        <button type="submit" class="btn btn-info text-white">Submit Requirement</button>
                    </form>
                </section>

                <!-- FR27: View status of submitted requirements -->
                <section id="requirement-status" class="mb-5">
                    <h3>My Requirement Status</h3>
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Project Title</th>
                                <th>Submitted On</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Web App Design</td>
                                <td>2025-09-01</td>
                                <td><span class="badge bg-info">Under Review</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Mobile App</td>
                                <td>2025-08-15</td>
                                <td><span class="badge bg-info">Approved</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>E-commerce Portal</td>
                                <td>2025-07-20</td>
                                <td><span class="badge bg-info">Rejected</span></td>
                            </tr>
                        </tbody>
                    </table>
                </section>

                <!-- FR28: History of projects shown interest in -->
                <section id="interested-projects" class="mb-5">
                    <h3>Interested Projects</h3>
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Project Name</th>
                                <th>Date of Interest</th>
                                <th>Status / Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>AI Chatbot</td>
                                <td>2025-06-30</td>
                                <td>Pending Owner Response</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Data Analytics Dashboard</td>
                                <td>2025-05-12</td>
                                <td>Interview Scheduled</td>
                            </tr>
                        </tbody>
                    </table>
                </section>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Quick Link</h4>
                    <a class="btn btn-link" href="./about.php">About Us</a>
                    <a class="btn btn-link" href="./contact.php">Contact Us</a>
                    <a class="btn btn-link" href="">Privacy Policy</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">FAQs & Help</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Contact</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>Survey No. 64, Madhapur,</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+91-9441927859</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@vsoftssolutions.in</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Gallery</h4>
                    <div class="row g-2 pt-2">
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/major.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/mini.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/sathInternshp.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/sathvikacyber.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/sathStructural.jpg" alt="">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid bg-light p-1" src="img/mini.jpg" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4 class="text-white mb-3">Newsletter</h4>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control border-0 w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="copyright">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a class="border-bottom" href="./">WesTechnologies.in</a><br><br>
                        <!-- Distributed By <a class="border-bottom" href="https://themewagon.com">ThemeWagon</a> -->
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="footer-menu">
                            <a href="">Home</a>
                            <!-- <a href="">Cookies</a> -->
                            <a href="">Help</a>
                            <a href="">FQAs</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top
    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up style=color: white;"></i></a>
 -->

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
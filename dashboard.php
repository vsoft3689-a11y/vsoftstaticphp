<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Terms and Conditions | VSoft</title>
  
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
    <!-- <link href="css/terms.css" rel="stylesheet"> -->
 
   
</head>

<body class="bg-light">
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
                <a href="./index.php" class="nav-item nav-link active">Home</a>
                <a href="./about.php" class="nav-item nav-link">About</a>
                <a href="./services.php" class="nav-item nav-link">Services</a>
                <a href="./projects.php" class="nav-item nav-link">Projects</a>
                <a href="./internship.php" class="nav-item nav-link">Internship</a>
                <a href="./contact.php" class="nav-item nav-link">Contact</a>
            </div>
            <a href="./index.php" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Logout<i class="fa fa-arrow-right ms-3"></i></a>
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
                    <a href="#custom-requirement" class="list-group-item list-group-item-action">Custom Requirement</a>
                    <a href="#requirement-status" class="list-group-item list-group-item-action">My Requiremen Status</a>
                    <a href="#interested-projects" class="list-group-item list-group-item-action">Interested Projects</a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">

                <!-- FR24: Dashboard overview -->
                <section id="overview" class="mb-5">
                    <h3>Dashboard Overview</h3>
                    <div class="row gy-3">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary ">
                                <div class="card-body">
                                    <h4 class="card-title text-white">Custom Requirements</h4>
                                    <h5 class="card-text text-white">5</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h4 class="card-title text-white">Under Review</h4>
                                    <h5 class="card-text text-white">2</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h4 class="card-title text-white">Approved / Rejected</h4>
                                    <h5 class="card-text text-white">3</h5>
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
                            <input type="email" name="email" class="form-control" value="suryavardhan@gmail.com" disabled>
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
                        <button type="submit" class="btn btn-primary text-white">Submit Requirement</button>
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
                                <td><span class="badge bg-primary">Under Review</span></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Mobile App</td>
                                <td>2025-08-15</td>
                                <td><span class="badge bg-primary">Approved</span></td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>E-commerce Portal</td>
                                <td>2025-07-20</td>
                                <td><span class="badge bg-primary">Rejected</span></td>
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
    <!-- Footer Start -->
    
    <?php include 'footer.php'; ?>

    <!-- Footer End -->
</body>

</html>
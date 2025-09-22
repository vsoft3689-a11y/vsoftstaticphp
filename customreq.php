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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Submit Custom Project Requirement</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .fade-out { transition: opacity 0.4s ease; opacity: 0; }

    /* Mobile card view for table rows */
    @media (max-width: 768px) {
      table thead { display: none; }
      table, table tbody, table tr, table td {
        display: block;
        width: 100%;
      }
      table tr {
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
        border-radius: .5rem;
        padding: .75rem;
        background: #fff;
      }
      table td {
        text-align: left !important;
        padding: .4rem 0;
      }
      table td::before {
        content: attr(data-label);
        font-weight: bold;
        display: block;
        color: #495057;
        margin-bottom: 0.2rem;
      }
    }
  </style>
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

  <div class="container mt-4 mb-5">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-10">

        <!-- Form -->
        <div class="card shadow-lg rounded-3 mb-4">
          <div class="card-header bg-primary text-white text-center">
            <h4>Submit Custom Project Requirement</h4>
          </div>
          <div class="card-body">
            <form id="requirementForm">
              <!-- Project Title -->
              <div class="mb-3">
                <label class="form-label">Project Title <span class="text-danger">*</span></label>
                <input type="text" id="title" class="form-control" placeholder="Enter project title" required>
              </div>

              <!-- Description -->
              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea id="description" class="form-control" rows="3" placeholder="Describe your project idea"></textarea>
              </div>

              <!-- Technologies -->
              <div class="mb-3">
                <label class="form-label">Technologies Required</label>
                <input type="text" id="technologies" class="form-control" placeholder="e.g. Python, AI, IoT">
              </div>

              <!-- Branch -->
              <div class="mb-3">
                <label class="form-label">Branch</label>
                <select id="branch" class="form-select">
                  <option selected disabled>Select branch</option>
                  <option value="CSE">Computer Science</option>
                  <option value="ECE">Electronics</option>
                  <option value="EEE">Electrical</option>
                  <option value="MECH">Mechanical</option>
                  <option value="CIVIL">Civil</option>
                </select>
              </div>

              <!-- Deadline -->
              <div class="mb-3">
                <label class="form-label">Deadline</label>
                <input type="date" id="deadline" class="form-control">
              </div>

              <!-- File Upload -->
              <div class="mb-3">
                <label class="form-label">Upload Reference Document</label>
                <input type="file" id="document" class="form-control">
              </div>

              <!-- Submit -->
              <div class="d-grid">
                <button type="submit" class="btn btn-success">Submit Requirement</button>
              </div>
            </form>
          </div>
        </div>

        <!-- Submitted Requirements -->
        <div class="card shadow-lg rounded-3">
          <div class="card-header bg-dark text-white text-center">
            <h5>My Submitted Requirements</h5>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-hover align-middle mb-0" id="requirementsTable">
                <thead class="table-light">
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Branch</th>
                    <th>Technologies</th>
                    <th>Deadline</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr id="emptyRow">
                    <td colspan="6" class="text-center text-muted">No requirements submitted yet.</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const form = document.getElementById("requirementForm");
    const tableBody = document.querySelector("#requirementsTable tbody");
    const emptyRow = document.getElementById("emptyRow");
    let count = 0;

    // Handle Form Submit
    form.addEventListener("submit", function(e) {
      e.preventDefault();

      count++;
      const title = document.getElementById("title").value;
      const description = document.getElementById("description").value;
      const technologies = document.getElementById("technologies").value;
      const branch = document.getElementById("branch").value;
      const deadline = document.getElementById("deadline").value;

      // Hide empty row
      if (emptyRow) emptyRow.remove();

      // Insert into table
      const row = document.createElement("tr");
      row.innerHTML = `
        <td data-label="#">${count}</td>
        <td data-label="Title">${title}</td>
        <td data-label="Branch">${branch || "-"}</td>
        <td data-label="Technologies">${technologies || "-"}</td>
        <td data-label="Deadline">${deadline || "-"}</td>
        <td data-label="Status">
          <button class="btn btn-sm btn-danger remove-btn">Remove</button>
        </td>
      `;

      tableBody.appendChild(row);

      // Reset form
      form.reset();
    });

    // Handle Remove
    tableBody.addEventListener("click", function(e) {
      if (e.target.classList.contains("remove-btn")) {
        const row = e.target.closest("tr");
        row.classList.add("fade-out");
        setTimeout(() => row.remove(), 400);

        // Show "no data" if table becomes empty
        if (tableBody.rows.length === 0) {
          const newRow = document.createElement("tr");
          newRow.id = "emptyRow";
          newRow.innerHTML = `<td colspan="6" class="text-center text-muted">No requirements submitted yet.</td>`;
          tableBody.appendChild(newRow);
        }
      }
    });
  </script>
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

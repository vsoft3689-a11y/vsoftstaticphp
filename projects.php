<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>vsofts solutions</title>
  
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
  <link href="css/projects.css" rel="stylesheet">

</head>
<body>
  

  <!-- Header Start -->
  <div class="container-fluid bg-primary py-5 mb-5 projects-header">
    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-lg-10 text-center">
          <h1 class="display-3 text-white animated slideInDown">OUR PROJECTS</h1>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center">
              <li class="breadcrumb-item"><a class="text-white" href="./index.php">Home</a></li>
              <li class="breadcrumb-item"><a class="text-white" href="./about.php">Pages</a></li>
              <li class="breadcrumb-item text-white active" aria-current="./projects.php">Projects</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <!-- Header End -->

  <div class="container project-selection">
    <h2 class="text-center mb-4">Project Selection</h2>
    <form method="POST">
      <select name="degree" id="degree" required onchange="updateBranches()">
        <option value="">Select Degree</option>
        <option value="BTech">B.Tech</option>
        <option value="MTech">M.Tech</option>
        <option value="MCA">MCA</option>
        <option value="MBA">MBA</option>
      </select>

      <select name="branch" id="branch" required>
        <option value="">Select Branch</option>
      </select>

      <div id="projectTypeDiv">
        <select name="project_type" id="project_type">
          <option value="">Select Project Type</option>
          <option value="Mini">Mini Project</option>
          <option value="Major">Major Project</option>
        </select>
      </div>

      <select name="domain" id="domain" required>
        <option value="">Select Domain</option>
      </select>

      <button type="submit">Submit</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $degree = $_POST['degree'];
      $branch = $_POST['branch'];
      $domain = $_POST['domain'];
      $projectType = $_POST['project_type'] ?? 'N/A';

      // Example file path (replace with your actual project files)
      // $filePath = "projects/$degree/$branch/$domain/sample.pdf"; $filePath

      echo "<table>
              <tr><th>Title</th><th>Description</th><th>Technologies</th><th>Watch Here</th><th>Abstarct-File</th></tr>
              <tr>
                <td>$degree Project</td>
                <td>Project for $degree - $branch in $domain</td>
                <td>PHP, MySQL, HTML, CSS</td>
                <td><a href='#' </a>Youtube link </td>
                <td>
                  
                  <a href='#' download class='download-link'>Download</a>
                </td>
              </tr>
            </table>";
    }
    ?>
  </div>

  <script>
    function updateBranches() {
      let degree = document.getElementById("degree").value;
      let branch = document.getElementById("branch");
      let domain = document.getElementById("domain");
      let projectTypeDiv = document.getElementById("projectTypeDiv");

      branch.innerHTML = "<option value=''>Select Branch</option>";
      domain.innerHTML = "<option value=''>Select Domain</option>";
      projectTypeDiv.style.display = "block";

      if (degree === "BTech") {
        ["CSE", "ECE", "EEE", "Civil", "Mech"].forEach(b => {
          branch.innerHTML += `<option value="${b}">${b}</option>`;
        });
      } else if (degree === "MTech") {
        ["CSE", "ECE", "Power Systems", "Structural Engineering"].forEach(b => {
          branch.innerHTML += `<option value="${b}">${b}</option>`;
        });
      } else if (degree === "MCA") {
        branch.innerHTML = "<option value='MCA'>MCA</option>";
        projectTypeDiv.style.display = "none";
        ["Database Systems", "Web delevelopment", "AI/ML", "Mobile Applications"].forEach(d => {
          domain.innerHTML += `<option value="${d}">${d}</option>`;
        });
      } else if (degree === "MBA") {
        branch.innerHTML = "<option value='MBA'>MBA</option>";
        projectTypeDiv.style.display = "none";
        ["Marketing", "Finance", "HR", "Operations"].forEach(d => {
          domain.innerHTML += `<option value="${d}">${d}</option>`;
        });
      }
    }

    document.getElementById("branch").addEventListener("change", function() {
      let branch = this.value;
      let degree = document.getElementById("degree").value;
      let domain = document.getElementById("domain");

      domain.innerHTML = "<option value=''>Select Domain</option>";

      if (degree === "BTech") {
        if (branch === "CSE") {
          ["Web Development", "AI/ML", "Cloud Computing", "App Development", "Cyber Security"].forEach(d => {
            domain.innerHTML += `<option value="${d}">${d}</option>`;
          });
        } else if (branch === "ECE") {
          ["VLSI", "Embedded Systems", "IoT", "Robotics"].forEach(d => {
            domain.innerHTML += `<option value="${d}">${d}</option>`;
          });
        } else if (branch === "EEE") {
          ["Power Electronics", "Renewable Energy", "Smart Grids"].forEach(d => {
            domain.innerHTML += `<option value="${d}">${d}</option>`;
          });
        } else if (branch === "Civil") {
          ["Structural Analysis", "Construction Management", "Geotechnical"].forEach(d => {
            domain.innerHTML += `<option value="${d}">${d}</option>`;
          });
        } else if (branch === "Mech") {
          ["Thermal Engineering", "Automobile", "Manufacturing", "Mechatronics"].forEach(d => {
            domain.innerHTML += `<option value="${d}">${d}</option>`;
          });
        }
      } else if (degree === "MTech") {
        if (branch === "CSE") {
          ["Data Mining", "Block Chain", "Network Security"].forEach(d => {
            domain.innerHTML += `<option value="${d}">${d}</option>`;
          });
        } else if (branch === "ECE") {
          ["Wireless Communication", "Signal Processing", "VLSI Design"].forEach(d => {
            domain.innerHTML += `<option value="${d}">${d}</option>`;
          });
        } else if (branch === "Power Systems") {
          ["Facts", "Smart energy system", "Load flow studies"].forEach(d => {
            domain.innerHTML += `<option value="${d}">${d}</option>`;
          });
        } else if (branch === "Structural Engineering") {
          ["Finite element", "Concrete Technology", "Seismic Design"].forEach(d => {
            domain.innerHTML += `<option value="${d}">${d}</option>`;
          });
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
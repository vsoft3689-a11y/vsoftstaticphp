<?php 
include './config/database.php';

$conn = (new Database())->connect();

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => $conn->connect_error]));
}

// Fetch distinct values for dropdowns
$degreeResult = $conn->query("SELECT DISTINCT degree FROM projects ORDER BY degree ASC");
$branchResult = $conn->query("SELECT DISTINCT branch FROM projects ORDER BY branch ASC");
$domainResult = $conn->query("SELECT DISTINCT domain FROM projects ORDER BY domain ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>VSoft Solutions</title>

  <link href="img/favicon.ico" rel="icon">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
  <link href="css/projects.css" rel="stylesheet">
</head>
<body>

<?php include 'navbar.php'; ?>

<!-- Page Header -->
<div class="container-fluid bg-primary py-5 mb-5 projects-header">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-10 text-center">
        <h1 class="display-3 text-white">OUR PROJECTS</h1>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item"><a class="text-white" href="./index.php">Home</a></li>
            <li class="breadcrumb-item"><a class="text-white" href="./about.php">About</a></li>
            <li class="breadcrumb-item"><a class="text-white" href="./projects.php">Projects</a></li>
          </ol>
        </nav>
      </div>
    </div>
  </div>
</div>

<!-- Project Selection Form -->
<div class="container project-selection">
  <div class="text-center"><h2>Project Selection</h2></div>

  <form method="POST" class="mb-4">

    <!-- Degree -->
    <select name="degree" id="degree" required>
      <option value="">Select Degree</option>
      <?php 
      if ($degreeResult && $degreeResult->num_rows > 0) {
          while ($row = $degreeResult->fetch_assoc()) {
              $deg = htmlspecialchars($row['degree']);
              echo '<option value="'.$deg.'">'.$deg.'</option>';
          }
      }
      ?>
    </select>

    <!-- Branch -->
    <select name="branch" id="branch" required>
      <option value="">Select Branch</option>
      <?php 
      if ($branchResult && $branchResult->num_rows > 0) {
          while ($row = $branchResult->fetch_assoc()) {
              $br = htmlspecialchars($row['branch']);
              echo '<option value="'.$br.'">'.$br.'</option>';
          }
      }
      ?>
    </select>

    <!-- Project Type -->
    <select name="project_type" id="project_type">
      <option value="">Select Project Type</option>
      <option value="mini">Mini Project</option>
      <option value="major">Major Project</option>
    </select>

    <!-- Domain -->
    <select name="domain" id="domain" required>
      <option value="">Select Domain</option>
      <?php 
      if ($domainResult && $domainResult->num_rows > 0) {
          while ($row = $domainResult->fetch_assoc()) {
              $dm = htmlspecialchars($row['domain']);
              echo '<option value="'.$dm.'">'.$dm.'</option>';
          }
      }
      ?>
    </select>

    <button type="submit">Submit</button>
  </form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $degree = trim($_POST['degree']);
    $branch = trim($_POST['branch']);
    $projectType = $_POST['project_type'] ?? '';
    $domain = trim($_POST['domain']);

    // Normalize values for matching
    $degree = strtolower($degree);
    $branch = strtolower($branch);
    $projectType = strtolower($projectType);
    $domain = strtolower($domain);

    echo "<pre>Selected Filters:\n";
    echo "Degree: $degree\nBranch: $branch\nType: $projectType\nDomain: $domain\n</pre>";

    // Build query
    $sql = "SELECT * FROM projects 
            WHERE LOWER(degree)=? 
              AND LOWER(branch)=? 
              AND LOWER(domain)=?";
    $params = [$degree, $branch, $domain];

    if (!empty($projectType)) {
        $sql .= " AND LOWER(type)=?";
        $params[] = $projectType;
    }

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("<p class='text-danger'>Prepare failed: ".$conn->error."</p>");
    }

    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($stmt->error) {
        echo "<p class='text-danger'>SQL Error: ".$stmt->error."</p>";
    }

    if ($result && $result->num_rows > 0) {
        echo "<table class='table table-bordered mt-4'>
                <tr>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Technologies</th>
                  <th>Price</th>
                  <th>Demo Video</th>
                  <th>Abstract File</th>
                  <th>Base Paper</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>".htmlspecialchars($row['title'])."</td>
                <td>".htmlspecialchars($row['description'])."</td>
                <td>".htmlspecialchars($row['technologies'])."</td>
                <td>₹".htmlspecialchars($row['price'])."</td>
                <td>";
            if (!empty($row['youtube_url'])) {
                echo "<a href='".htmlspecialchars($row['youtube_url'])."' target='_blank'><i class='fab fa-youtube'></i> YouTube</a>";
            }
            echo "</td>
                <td>";
            if (!empty($row['file_path_abstract'])) {
                echo "<a href='".htmlspecialchars($row['file_path_abstract'])."' download><i class='fa fa-download'></i> Download</a>";
            }
            echo "</td>
                <td>";
            if (!empty($row['file_path_basepaper'])) {
                echo "<a href='".htmlspecialchars($row['file_path_basepaper'])."' download><i class='fa fa-download'></i> Download</a>";
            }
            echo "</td>
            </tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='mt-4 text-danger'>No projects found!</p>";
    }
}
$conn->close();
?>
</div>

<?php include 'footer.php'; ?>

<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/wow/wow.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>

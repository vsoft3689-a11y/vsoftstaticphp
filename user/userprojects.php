<?php
session_start();
include '../config/database.php';

// Simple user login check (replace with your auth system)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = (new Database())->connect();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$results = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $degree = $_POST['degree'] ?? '';
    $branch = $_POST['branch'] ?? '';
    $domain = $_POST['domain'] ?? '';
    $projectType = $_POST['project_type'] ?? '';

    $sql = "SELECT * FROM projects WHERE degree = ? AND branch = ? AND domain = ?";
    $params = [$degree, $branch, $domain];
    $types = "sss";

    if (!empty($projectType)) {
        $sql .= " AND type = ?";
        $params[] = strtolower($projectType);
        $types .= "s";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();
    $results = $res->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// Handle Interested click
if (isset($_GET['action']) && $_GET['action'] === 'interested' && isset($_GET['project_id'])) {
    $user_id = $_SESSION['user_id'];
    $project_id = intval($_GET['project_id']);

    // Insert if not exists
    $checkSql = "SELECT * FROM user_interested_projects WHERE user_id = ? AND project_id = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("ii", $user_id, $project_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $insertSql = "INSERT INTO user_interested_projects (user_id, project_id) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($insertSql);
        $stmtInsert->bind_param("ii", $user_id, $project_id);
        $stmtInsert->execute();
        $stmtInsert->close();
    }

    $stmt->close();

    // Redirect to project history page
    header("Location: projecthistory.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>User Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        .project-selection {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            border: 2px solid #06BBCC;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
            margin-top:100px;
        }
        table th {
            background-color: #06BBCC;
            color: #fff;
            text-transform: uppercase;
        }
        .btn-interested {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-weight: 600;
        }
        .btn-interested:hover {
            background-color: #218838;
            color: white;
        }
    </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="container project-selection">
    <h2 class="text-center mb-4">Projects</h2>
    <form method="POST" class="row g-3 justify-content-center">
        <div class="col-md-3">
            <select name="degree" id="degree" class="form-select" required onchange="updateBranches()">
                <option value="">Select Degree</option>
                <option value="B.Tech">B.Tech</option>
                <option value="M.Tech">M.Tech</option>
                <option value="MCA">MCA</option>
                <option value="MBA">MBA</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="branch" id="branch" class="form-select" required onchange="updateDomains()">
                <option value="">Select Branch</option>
            </select>
        </div>
        <div class="col-md-3">
            <select name="domain" id="domain" class="form-select" required>
                <option value="">Select Domain</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="project_type" id="project_type" class="form-select">
                <option value="">Select Project Type</option>
                <option value="mini">Mini Project</option>
                <option value="major">Major Project</option>
            </select>
        </div>
        <div class="col-md-1">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </div>
    </form>

    <div class="mt-4">
        <?php if(count($results) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Technologies</th>
                    <th>Price</th>
                    <th>Demo Video</th>
                    <th>Abstract</th>
                    <th>Base Paper</th>
                    <th>Interested</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['description']) ?></td>
                    <td><?= htmlspecialchars($row['technologies']) ?></td>
                    <td>₹<?= htmlspecialchars($row['price']) ?></td>
                    <td>
                        <?php if(!empty($row['youtube_url'])): ?>
                            <a href="<?= htmlspecialchars($row['youtube_url']) ?>" target="_blank" class="btn btn-sm btn-danger">
                                <i class="fab fa-youtube"></i> Watch
                            </a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(!empty($row['file_path_abstract'])): ?>
                            <a href="<?= htmlspecialchars($row['file_path_abstract']) ?>" download class="btn btn-sm btn-info">Download</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if(!empty($row['file_path_basepaper'])): ?>
                            <a href="<?= htmlspecialchars($row['file_path_basepaper']) ?>" download class="btn btn-sm btn-info">Download</a>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="?action=interested&project_id=<?= intval($row['id']) ?>" class="btn-interested">Interested</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <!-- <p class="text-center mt-3">No projects found for your selection.</p> -->
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
function updateBranches() {
    const degree = document.getElementById('degree').value;
    const branch = document.getElementById('branch');
    const domain = document.getElementById('domain');

    branch.innerHTML = '<option value="">Select Branch</option>';
    domain.innerHTML = '<option value="">Select Domain</option>';

    if (degree === 'B.Tech') {
        ['CSE', 'ECE', 'EEE', 'Civil', 'Mech'].forEach(b => {
            branch.innerHTML += `<option value="${b}">${b}</option>`;
        });
    } else if (degree === 'M.Tech') {
        ['CSE', 'ECE', 'Power Systems', 'Structural Engineering'].forEach(b => {
            branch.innerHTML += `<option value="${b}">${b}</option>`;
        });
    } else if (degree === 'MCA') {
        ['Software Engineering', 'Networking', 'Hardware Technologies', 'Management Information Systems'].forEach(b => {
            branch.innerHTML += `<option value="${b}">${b}</option>`;
        });
    } else if (degree === 'MBA') {
        ['Marketing', 'Finance', 'Hospitality & Tourism', 'Banking & Insurance'].forEach(b => {
            branch.innerHTML += `<option value="${b}">${b}</option>`;
        });
    }
}

function updateDomains() {
    const degree = document.getElementById('degree').value;
    const branch = document.getElementById('branch').value;
    const domain = document.getElementById('domain');

    domain.innerHTML = '<option value="">Select Domain</option>';

    if(degree === 'B.Tech'){
        if(branch === 'CSE'){
            ['Web Development', 'AI/ML', 'Cloud Computing', 'App Development', 'Cyber Security'].forEach(d => {
                domain.innerHTML += `<option value="${d}">${d}</option>`;
            });
        } else if(branch === 'ECE'){
            ['VLSI', 'Embedded Systems', 'IoT', 'Robotics'].forEach(d => {
                domain.innerHTML += `<option value="${d}">${d}</option>`;
            });
        } else if(branch === 'EEE'){
            ['Power Electronics', 'Renewable Energy', 'Smart Grids'].forEach(d => {
                domain.innerHTML += `<option value="${d}">${d}</option>`;
            });
        } else if(branch === 'Civil'){
            ['Structural Analysis', 'Construction Management', 'Geotechnical'].forEach(d => {
                domain.innerHTML += `<option value="${d}">${d}</option>`;
            });
        } else if(branch === 'Mech'){
            ['Thermal Engineering', 'Automobile', 'Manufacturing', 'Mechatronics'].forEach(d => {
                domain.innerHTML += `<option value="${d}">${d}</option>`;
            });
        }
    }
    // Add similar for M.Tech, MCA, MBA if needed
}
</script>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
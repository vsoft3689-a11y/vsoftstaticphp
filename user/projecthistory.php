<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$conn = (new Database())->connect();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT p.* FROM projects p
        INNER JOIN user_interested_projects uip ON p.id = uip.project_id
        WHERE uip.user_id = ? ORDER BY uip.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$projects = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Interested Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        
        .history-section {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            border: 2px solid #06BBCC;
            box-shadow: 0 6px 20px rgba(0,0,0,0.08);
        }
        table th {
            background-color: #06BBCC;
            color: #fff;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<?php include 'user_navbar.php'; ?>

<div class="container history-section">
    <h2 class="text-center mb-4">Your Interested Projects</h2>

    <?php if(count($projects) > 0): ?>
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
                </tr>
            </thead>
            <tbody>
                <?php foreach($projects as $row): ?>
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
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p class="text-center">You have not marked any projects as interested yet.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="userprojects.php" class="btn btn-secondary">Back to Projects</a>
    </div>
</div>

<?php include 'footer.php'; ?>

<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
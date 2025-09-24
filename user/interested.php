<?php
// user/interested.php

include '../config/database.php';
session_start();

$conn = (new Database())->connect();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['user_id'] = 1; // simulate login for testing
}
$user_id = $_SESSION['user_id'];

// Handle marking interest
if (isset($_GET['project_id'])) {
    $project_id = intval($_GET['project_id']);

    // Prevent duplicates
    $stmt = $conn->prepare("SELECT * FROM user_interested_projects WHERE user_id = ? AND project_id = ?");
    $stmt->bind_param("ii", $user_id, $project_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO user_interested_projects (user_id, project_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $project_id);
        $stmt->execute();
    }
    header("Location: interested.php");
    exit;
}

// Fetch interested projects
$stmt = $conn->prepare("SELECT p.* FROM projects p JOIN user_interested_projects uip ON p.id = uip.project_id WHERE uip.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$interestedProjects = $res->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interested Projects</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Your Interested Projects</h2>
    <?php if ($interestedProjects): ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Title</th><th>Description</th><th>Price</th><th>Abstract</th><th>Base Paper</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($interestedProjects as $proj): ?>
                    <tr>
                        <td><?= htmlspecialchars($proj['title']) ?></td>
                        <td><?= htmlspecialchars($proj['description']) ?></td>
                        <td>₹<?= $proj['price'] ?></td>
                        <td>
                            <?php if ($proj['file_path_abstract']): ?>
                                <a href="<?= $proj['file_path_abstract'] ?>" download>Download</a>
                            <?php else: ?>N/A<?php endif; ?>
                        </td>
                        <td>
                            <?php if ($proj['file_path_basepaper']): ?>
                                <a href="<?= $proj['file_path_basepaper'] ?>" download>Download</a>
                            <?php else: ?>N/A<?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info">You have not marked any projects as interested.</div>
    <?php endif ?>
    <a href="userprojects.php" class="btn btn-secondary mt-3">Back to Projects</a>
</div>
</body>
</html>
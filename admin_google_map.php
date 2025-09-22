<style>
    .form-box {
    background: #fff;
    padding: 20px;
    margin: 20px auto;   /* <-- this centers horizontally */
    border-radius: 8px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    max-width: 500px;
}



</style>
<?php
include __DIR__ . '/config/database.php';
   // include DB class

// Create connection
$conn = (new Database())->connect();
if (!$conn) {
    die("Database connection failed.");
}

// ------------------- SAVE MAP -------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $google_map = $conn->real_escape_string($_POST['google_map']);

    // Check if google_map already exists
    $check = $conn->query("SELECT * FROM site_configurations WHERE config_key='google_map'");
    if ($check && $check->num_rows > 0) {
        // Update existing
        $conn->query("UPDATE site_configurations SET config_value='$google_map' WHERE config_key='google_map'");
    } else {
        // Insert new
        $conn->query("INSERT INTO site_configurations (config_key, config_value) VALUES ('google_map', '$google_map')");
    }

    echo "<script>alert('✅ Google Map updated successfully!'); window.location='site_config.php';</script>";
    exit;
}

// ------------------- LOAD CONFIGS -------------------
$configs = [];
$result = $conn->query("SELECT config_key, config_value FROM site_configurations");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $configs[$row['config_key']] = $row['config_value'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Google Map Config</title>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
</head>
<!-- <body class="container py-5"> -->

    <h2 class="mb-4" style="text-align:center";>Google Map</h2>

    <form method="POST" action="" class="form-box";>
        <div  class="mb-3" style="text-align:center";>
            <label class="form-label"  style="display:inline-block; width:450px; text-align:left;">Google Map Embed Code</label><br>
            <textarea name="google_map" class="form-control" rows="6" style="width:450px; height:150px;  border-radius: 8px; display:inline-block;";><?= $configs['google_map'] ?? '' ?></textarea>
        </div>
        <div style="text-align:center; margin-top:10px;">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

        <!-- <button type="submit" class="btn btn-primary">Save</button> -->
    </form>

</body>
</html>
<?php
// subscribe.php (inside views/)
include __DIR__ . '/../config/database.php';

$db = new Database();
$conn = $db->connect();

if (!$conn) {
    die("Database connection failed.");
}

// rest is same as above...

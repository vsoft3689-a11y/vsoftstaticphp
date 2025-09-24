<?php
// Common auth guard for user pages
// Place this at the very top of protected pages before any output

// Prevent back-navigation from showing cached pages after logout
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: 0');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user']) || empty($_SESSION['user']['id'])) {
    header('Location: ../login.php');
    exit();
}

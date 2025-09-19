<?php
session_start();

// Unset all session variables
$_SESSION = [];

// Destroy session
session_destroy();

// To be safe, also delete the session cookie if used
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Redirect with flash message
session_start();  // start new session to set flash message
$_SESSION['success_msg'] = "You have been logged out successfully.";

// Send headers to prevent caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies

header("Location: login.php");
exit();

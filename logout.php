<?php
// public/logout.php
session_start();
// Clear session data
$_SESSION = [];
session_unset();
session_destroy();
// Optionally clear remember me cookies
header('Location: login.php');
exit;

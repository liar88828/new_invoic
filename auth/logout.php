
# 7. Logout Page (public/logout.php)
<?php
session_start();
require_once '../utils/auth.php';

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
redirect('../index.php');
<?php
session_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Set timeout duration (1 hour = 3600 seconds)
$timeoutDuration = 3600;

// Check for last activity
if (isset($_SESSION['LAST_ACTIVITY']) && isset($_SESSION['user_id'])) {
    $elapsedTime = time() - $_SESSION['LAST_ACTIVITY'];
    
    // Print session information to screen
    
    
    if ($elapsedTime > $timeoutDuration) {
        // Session expired
        session_unset();     // remove all session variables
        session_destroy();   // destroy the session
        header("Location: login.php?session=expired"); // redirect with optional message
        exit;
    }
}

// Update last activity time
$_SESSION['LAST_ACTIVITY'] = time();
?>

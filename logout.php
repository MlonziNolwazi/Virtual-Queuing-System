
<?php
session_start();
session_unset();
session_destroy();

$message = '';
if (isset($_GET['timeout'])) {
    $message = 'You were logged out due to inactivity.';
} else {
    $message = 'You have been logged out.';
}

// Prevent back navigation
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
header("Pragma: no-cache");
header("Location: login.php?message=" . urlencode($message));
exit;
?>

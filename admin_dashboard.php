<?php
include 'timeout.php';

// Check if user is logged in
if (!isset($_SESSION['role']) || !isset($_SESSION['user_id'])) {
    // If no valid session, redirect to login
    header('Location: login.php');
    exit();
}

// Use actual session data instead of dummy data
$username = $_SESSION['username'] ?? $_SESSION['fullname'] ?? 'User';
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Mobile Responsive Panel</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include('includes/navbar.php'); ?>

<!-- Main Content -->
<div class="container-fluid">
  <div class="row">
    <?php include('includes/sidebar.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <p class="mt-4">Dashboard/</p>
      <h1 class="mt-4">Welcome, <?php echo $username; ?>!</h1>
      <p>This is the main content area.</p>
    </main>
  </div>
</div>
<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }

  window.addEventListener('pageshow', function (event) {
    if (event.persisted || (window.performance && performance.getEntriesByType("navigation")[0].type === "back_forward")) {
      // Redirect to login if coming from cache
      window.location.href = 'login.php';
    }
  });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Update date and time for all sidebar instances
  function updateDateTime() {
    const now = new Date();
    const timeString = now.toLocaleTimeString();
    const dateString = now.toLocaleDateString();
    
    // Update all elements with time-display class
    document.querySelectorAll('.time-display').forEach(element => {
      element.textContent = timeString;
    });
    
    // Update all elements with date-display class
    document.querySelectorAll('.date-display').forEach(element => {
      element.textContent = dateString;
    });
  }
  
  // Update immediately when page loads
  document.addEventListener('DOMContentLoaded', function() {
    updateDateTime();
    // Update every second
    setInterval(updateDateTime, 1000);
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  let warningTime = 55 * 60 * 1000; // 55 minutes
  let logoutTime  = 60 * 60 * 1000; // 60 minutes

  let warningTimer, logoutTimer;

  function resetTimers() {
      clearTimeout(warningTimer);
      clearTimeout(logoutTimer);

      warningTimer = setTimeout(() => {
          Swal.fire({
              title: "Session Expiring Soon",
              text: "You’ve been inactive. You will be logged out in 5 minutes unless there's activity.",
              icon: "warning",
              timer: 5000,
              toast: true,
              position: 'top-end',
              showConfirmButton: false
          });
      }, warningTime);

      logoutTimer = setTimeout(() => {
          // Redirect to logout
          window.location.href = "logout.php?timeout=1";
      }, logoutTime);
  }

  // Listen for activity
  ['click', 'mousemove', 'keydown', 'scroll'].forEach(event => {
      document.addEventListener(event, resetTimers, false);
  });

  resetTimers(); // Start timers on load
</script>

</body>
</html>

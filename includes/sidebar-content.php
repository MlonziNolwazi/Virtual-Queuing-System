<?php 
// Debug: Display current session role
$userRole = isset($_SESSION['role']) ? strtolower($_SESSION['role']) : 'not_set';
?>

<!-- Debug info (remove in production) -->
<!-- <div class="alert alert-info" style="font-size: 0.8rem;">
  <strong>Debug:</strong> Role = <?php echo isset($_SESSION['role']) ? $_SESSION['role'] : 'NOT SET'; ?>
</div> -->

<ul class="nav flex-column mb-3">
  <?php if ($userRole === 'admin'): ?>
    <li class="nav-item">
      <a class="nav-link active" href="admin_dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Manage Users</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Reports</a>
    </li>

  <?php elseif ($userRole === 'client'): ?>
     <li class="nav-item">
      <a class="nav-link active" href="admin_dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="#">My Bookings</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Browse Services</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Feedback</a>
    </li>

  <?php elseif ($userRole === 'service_provider'): ?>
     <li class="nav-item">
      <a class="nav-link active" href="admin_dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link active" href="#">My Schedule</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Client Requests</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Earnings</a>
    </li>
  <?php else: ?>
    <!-- Fallback if role doesn't match any condition -->
    <li class="nav-item">
      <a class="nav-link active" href="admin_dashboard.php">Dashboard</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Profile</a>
    </li>
  <?php endif; ?>
</ul>

<hr>

<div class="px-3">
  <p><strong>Role:</strong> <?php echo $_SESSION['role']; ?></p>
  <p><strong>Time:</strong> <span class="time-display"></span></p>
  <p><strong>Date:</strong> <span class="date-display"></span></p>

  <form action="logout.php" method="post">
    <button type="submit" class="btn btn-sm btn-danger">Logout</button>
  </form>
</div>

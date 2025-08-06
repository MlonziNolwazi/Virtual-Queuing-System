
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" style="background-cololr: rgb(164, 38, 44);">
  <div class="container-fluid  mx-3">
    <!-- Burger Icon for Sidebar -->
    <button class="btn btn-outline-light me-2 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
      <span class="navbar-toggler-icon"></span>
    </button>

    <a class="navbar-brand" href="#">Smart-Q</a>

    <!-- Search Bar -->
    <form class="d-none d-md-flex ms-auto me-3" role="search">
      <input class="form-control form-control-sm me-2" type="search" placeholder="Search..." aria-label="Search">
    </form>

    <!-- Right Nav Items -->
    <ul class="navbar-nav align-items-center flex-row">
      <li class="nav-item me-3">
        <a class="nav-link text-white" href="edit_profile.php" title="Settings">
          <i class="fas fa-cog"></i>
        </a>
            </li>
      </li>
      <li class="nav-item me-2">
        <?php
          require 'php/config/config.php';
          $userId = $_SESSION['user_id'];
          $stmt = $connect->prepare("SELECT profile_picture FROM users WHERE id = ?");
          $stmt->bind_param("i", $userId);
          $stmt->execute();
          $result = $stmt->get_result();
          $user = $result->fetch_assoc();

          $profilePicture = $user['profile_picture'] ?? '';
          $profileImagePath = $profilePicture && file_exists("uploads/$profilePicture")
              ? "uploads/$profilePicture"
              : "assets/img/default.png";
          ?>

          <img src="<?php echo $profileImagePath; ?>" alt="Profile" class="rounded-circle" width="30" height="30">

      </li>
      <li class="nav-item">
        <span class="text-white"><?php echo $_SESSION['username']; ?></span>
      </li>
    </ul>
  </div>
</nav>

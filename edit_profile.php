<?php
session_start();
require 'php/config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
// Use actual session data instead of dummy data
$username = $_SESSION['username'] ?? $_SESSION['fullname'] ?? 'User';
$role = $_SESSION['role'];

$stmt = $connect->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
// Debug: Print all session values
// Store each field value from $user array
$fullName = $user['full_name'] ?? '';
$email = $user['email'] ?? '';
$userType = $user['user_type'] ?? '';
$createdAt = $user['created_at'] ?? '';
$updatedAt = $user['updated_at'] ?? '';
$profilePicture = $user['profile_picture'] ?? '';
$profileImagePath = ($profilePicture && file_exists("uploads/$profilePicture")) ? "uploads/$profilePicture" : "assets/img/default.png";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Update Profile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/api/config.js"></script>
  <style>
    body { background-color: #f8f9fa; }
    .update-wrapper { display: flex; align-items: center; justify-content: center; }
    .update-container { background: white; padding: 2rem; border-radius: 1rem; width: 100%; max-width: 450px; }
    .rounded-circle { border: 2px solid #ccc; object-fit: cover; }
    .upload-icon {
  bottom: 0;
  right: 0;
  position: absolute;
  background-color: #007bff;
  color: white;
  border-radius: 50%;
  padding: 6px;
  font-size: 12px;
  line-height: 1;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
  display: flex;
  align-items: center;
  justify-content: center;
}
.profile-pic {
  width: 80px;
  height: 80px;
  object-fit: cover;
  border: 2px solid #ddd;
}

  </style>
</head>
<body>


<?php include 'includes/navbar.php'; ?>
<!-- Main Content -->
<div class="container-fluid">
  <div class="row">
    <?php include('includes/sidebar.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <p class="mt-4">Settings /</p>
        <div class="update-wrapper">
    <div class="update-container">
        <div class="d-flex justify-content-center mb-3">
        <div class="position-relative" style="width: 80px; height: 80px;">
            <label for="profilePicInput" style="cursor: pointer;">
            <img src="<?php echo $profileImagePath; ?>" alt="Profile" class="rounded-circle profile-pic" id="previewPic">

            <div class="upload-icon position-absolute">
                <i class="fas fa-camera"></i>
            </div>
            </label>
            <input type="file" id="profilePicInput" accept="image/*" style="display: none;">
        </div>
        </div>



      <h4 class="text-center mb-3">Update Your Profile</h4>

      <form id="update-profile-form">
        <div class="mb-3">
          <input type="text" class="form-control" name="full_name" placeholder="Full Name" required value="<?php echo $fullName; ?>">
        </div>
        <div class="mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email" required value="<?php echo htmlspecialchars($email); ?>">
        </div>
        <div class="mb-3">
          <div class="input-group">
            <input type="password" class="form-control" id='password' name="password" placeholder="New Password (leave blank to keep current)" id="password">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
              <i class="fas fa-eye" id="passwordIcon"></i>
            </button>
          </div>
            <div class="error-message text-danger small" id="password-error"></div>
        </div>
        <div class="mb-3">
          <select class="form-control" name="user_type" required  <?php if ($userType !== 'admin') echo 'disabled'; ?> >
            <option value="client" <?php if ($userType == 'client') echo 'selected'; ?>>Client</option>
            <option value="service_provider" <?php if ($userType == 'service_provider') echo 'selected'; ?>>Service Provider</option>
            <option value="admin" <?php if ($userType == 'admin') echo 'selected'; ?>>Admin</option>
          </select>
        </div>
        <button type="submit" class="btn btn-secondary w-100 mb-2">Save Changes</button>
        <button type="button" class="btn btn-danger w-100" id="deactivateAccount">Deactivate Account</button>
      </form>
    </div>
  </div>
    </main>
  </div>
</div>

<script>
// Preview profile image
profilePicInput.onchange = () => {
  const file = profilePicInput.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = e => previewPic.src = e.target.result;
    reader.readAsDataURL(file);
  }
};

// Toggle password visibility
$('#togglePassword').click(() => {
  const input = $('#password');
  const icon = $('#passwordIcon');
  input.attr('type', input.attr('type') === 'password' ? 'text' : 'password');
  icon.toggleClass('fa-eye fa-eye-slash');
});

// Submit profile update using fetch()
document.getElementById('update-profile-form').addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);
  if (profilePicInput.files[0]) formData.append('profile_picture', profilePicInput.files[0]);
// Password validation
const password = document.getElementById('password').value;
debugger
if (password && password.trim() !== '') {
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/;
        if(!passwordRegex.test(password)){
            document.getElementById('password-error').textContent = "Password must be at least 8 characters long, contain uppercase and lowercase letters, a number, and a special character.";
            return;
        }

}


return new Promise((resolve, reject) => {
    $.ajax({
        url: 'php/update_profile.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(data) {
                debugger;
            if (data.status === 'success') {
                if (data.user) {
                    localStorage.setItem('user', JSON.stringify(data.user));
                }
                Swal.fire('Updated!', data.message, 'success').then(() => {
                    location.reload();
                });
                resolve(data);
            } else {
                Swal.fire('Error', data.message, 'error');
                reject(data);
            }
        },
        error: function(xhr, status, error) {
            
            console.error(error);
            Swal.fire('Error', 'Something went wrong. Try again.', 'error');
            reject(error);
        }
    });
});

});
</script>

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
  <script>

    document.getElementById('deactivateAccount').addEventListener('click', function () {

      const confirmDeactivation = confirm('Are you sure you want to deactivate your account? This action is irreversible.');
      if (confirmDeactivation) {
        const userId = <?php echo json_encode($_SESSION['user_id']); ?>;
        // Replace this with your backend call
        new Promise((resolve, reject) => {
            $.ajax({
                url: 'php/service/deactivate.php',
                type: 'POST',
                data: JSON.stringify({  deactivate: true , 
                    service: 'deactivate_user' 
                }),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    debugger;
                    Swal.fire('Account Deactivated', 'Your account has been deactivated.', 'success').then(() => {
                        window.location.href = `${APIURL}/../goodbye.php`;
                    });
                    resolve(response);
                },
                error: function(xhr, status, error) {
                    debugger;
                    console.error('Error:', error);
                    Swal.fire('Error', 'There was a problem deactivating your account.', 'error');
                    reject(error);
                }
            });
        });
      }
    });
  </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

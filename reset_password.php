<?php
include 'php/config/config.php'; // contains $connect
include 'php/config/base_config.php';

$token = $_GET['token'] ?? null;

if (!$token) {
    die("Invalid or missing token.");
}

// Validate token
$stmt = mysqli_prepare($connect, "SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW()");
mysqli_stmt_bind_param($stmt, "s", $token);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$resetRecord = mysqli_fetch_assoc($result);

if (!$resetRecord) {
    die("Token is invalid or expired.");
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    $hashed = password_hash($newPassword, PASSWORD_DEFAULT);

    $updateStmt = mysqli_prepare($connect, "UPDATE users SET password_hash = ? WHERE email = ?");
    mysqli_stmt_bind_param($updateStmt, "ss", $hashed, $resetRecord['email']);
    mysqli_stmt_execute($updateStmt);
    mysqli_stmt_close($updateStmt);

    $deleteStmt = mysqli_prepare($connect, "DELETE FROM password_resets WHERE email = ?");
    mysqli_stmt_bind_param($deleteStmt, "s", $resetRecord['email']);
    mysqli_stmt_execute($deleteStmt);
    mysqli_stmt_close($deleteStmt);

    echo "<script>
            alert('Password reset successful. Redirecting to login...');
            window.location.href = 'login.php';
            </script>";
    exit;
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="<?php echo $baseUrl; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
        <div style="background-color:rgb(7, 8, 8);">
     <?php include 'header.php'; ?>
</div>
 <div class="signup-wrapper">
<div class="signup-container">
    <div class="signup-logo">
        <img src="assets/img/queue.png" alt="Logo">
    </div>
    <h2 class="mb-4">Reset Password</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" id="reset-form">
        <div class="mb-3">
            <div class="input-group">
                <input type="password" name="password" class="form-control" placeholder="New password" required>
                <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                    <i class="fas fa-eye" id="newPasswordIcon"></i>
                </button>
            </div>
        </div>

        <div class="mb-3">
            <div class="input-group">
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                    <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                </button>
            </div>
        </div>

        <button type="submit" class="btn btn-secondary w-100">Reset Password</button>
        <a href="login.php" class="login-link mt-3 d-block">Back to Login</a>
    </form>
</div>
    </div>
       <?php include 'footer.php'; ?>
<script>
    // Toggle visibility for New Password
    document.getElementById('toggleNewPassword').addEventListener('click', function () {
        const pwd = document.querySelector('input[name="password"]');
        const icon = document.getElementById('newPasswordIcon');
        pwd.type = pwd.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });

    // Toggle visibility for Confirm Password
    document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
        const pwd = document.querySelector('input[name="confirm_password"]');
        const icon = document.getElementById('confirmPasswordIcon');
        pwd.type = pwd.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>

<script src='js/api/api.js'></script>
<script>
    document.getElementById('reset-form').addEventListener('submit', function (e) {
        const password = document.querySelector('input[name="password"]').value;
        const confirmPassword = document.querySelector('input[name="confirm_password"]').value;

        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

        if (!passwordRegex.test(password)) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Weak Password',
                text: 'Password must be at least 8 characters long and include uppercase, lowercase, number, and special character.'
            });
            return;
        }

        if (password !== confirmPassword) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'Passwords do not match.'
            });
            return;
        }
    });
    </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

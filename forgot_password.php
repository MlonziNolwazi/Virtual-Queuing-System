<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'php/config/base_config.php'; ?>
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
    <h2 class="mb-4">Forgot Password</h2>

    <form action="send_reset_email.php" method="POST" id="forgot-form">
        <div class="mb-3">
            <input type="email" class="form-control" name="email" placeholder="Enter your registered email" required>
        </div>

        <button type="submit" class="btn btn-secondary w-100">Send Reset Link</button>

        <a href="login.php" class="login-link mt-3 d-block">Back to Login</a>
    </form>
</div>
</div>
   <?php include 'footer.php'; ?>
<script src='js/api/api.js'></script>
<!-- Optional: JS file if needed -->
<!-- <script src="js/forgot_password.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

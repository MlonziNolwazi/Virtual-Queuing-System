<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'php/config/base_config.php'; ?>
    <base href="<?php echo $baseUrl; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/index.css">
    
</head>
<body>

    <?php include 'header.php'; ?>
    <?php
if (isset($_GET['message'])) {
    echo "<div class='alert alert-warning'>" . htmlspecialchars($_GET['message']) . "</div>";
}
?>

    <div class="signup-wrapper">
        <div class="signup-container">
            <div class="signup-logo">
                <img src="assets/img/queue.png" alt="Logo">
            </div>
            <h2 class="mb-4">Login</h2>

            <form id='login-form'>
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Your email" id="email" required>
                    <div class="error-message text-danger small" id="email-error"></div>
                </div>

                <div class="mb-3">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Your password" id="password" required>
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye" id="passwordIcon"></i>
                        </button>
                    </div>
                    <div class="error-message text-danger small" id="password-error"></div>
                </div>

                <button type="submit" class="btn btn-secondary w-100" id='login-submit'>Login</button>
                <a href="signup.php" class="login-link">Don't have an account? Sign up</a>
                <a href="forgot_password.php" class="login-link">Forgot your password?</a>
            </form>
        </div>
    </div>
    <?php include 'cookies.php'; ?>
    <?php include 'footer.php'; ?>
    <script src='js/api/api.js'></script>
    <script src="js/login.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JQuery  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

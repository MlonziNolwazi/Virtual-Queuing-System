<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
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
      <div class="signup-wrapper">
            <div class="signup-container">
            <div class="signup-logo">
                <img src="assets/img/queue.png" alt="Logo"> <!-- Replace with your logo path -->
            </div>
            <h2 class="mb-4">Sign Up</h2>

            <form id='signup-form'>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Pick your full name" id="fullName">
                    <div class="error-message text-danger small" id="fullName-error"></div>
                </div>

                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Your email" id="email">
                    <div class="error-message text-danger small" id="email-error"></div>
                </div>

                    <div class="mb-3">
                        <div class="input-group">
                        <input type="password" class="form-control" placeholder="Set a password (case sensitive)" id="password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                            <i class="fas fa-eye" id="passwordIcon"></i>
                        </button>
                        </div>
                        <div class="error-message text-danger small" id="password-error"></div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                        <input type="password" class="form-control" placeholder="Confirm your password" id="confirmPassword">
                        <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                            <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                        </button>
                        </div>
                        <div class="error-message text-danger small" id="confirmPassword-error"></div>
                    </div>

                <select class="form-control" id="userType">
                    <option value="" disabled>Select user type</option>
                    <option value="client" selected>Client</option>
                    <option value="service_provider">Service Provider</option>
                    <option value="admin">Admin</option>
                </select>

                <div class="form-check text-start mb-3">
                <input class="form-check-input" type="checkbox" required id="termsCheck">
                <label class="form-check-label" for="termsCheck">
                    When creating a new account, you agree to our <a href="terms.php">terms of service</a> and <a href="terms.php">privacy policy</a>.
                </label>
                </div>
                <div class="error-message" id="termsCheck-error"></div>

                <button type="submit" class="btn btn-secondary w-100" id='signup-submit' disabled>Sign Up</button>
                <button type="button" class="btn btn-success w-100 mt-2" id="populate-data">Populate Data</button>
                <a href="login.php" class="login-link">Are you already registered? Log in</a>
            </form>
            </div>
        </div>
      <?php include 'footer.php'; ?>
    <script src='js/api/api.js'></script>
    <script src="js/signup.js"></script>
    <!-- Sweet Alert Dialog -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JQuery  -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

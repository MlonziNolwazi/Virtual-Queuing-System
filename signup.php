<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php include 'php/config/base_config.php'; ?>
    <base href="<?php echo $baseUrl; ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    
    <div class="signup-container">
    <div class="signup-logo">
        <img src="assets/img/queue.png" alt="Logo"> <!-- Replace with your logo path -->
    </div>
    <h2 class="mb-4">Sign Up</h2>

    <form>
        <input type="text" class="form-control" placeholder="Pick a username" required>
        <input type="text" class="form-control" placeholder="Pick your full name" required>
        <input type="email" class="form-control" placeholder="Your email" required>
        <input type="password" class="form-control" placeholder="Set a password (case sensitive)" required>

        <div class="form-check text-start mb-3">
        <input class="form-check-input" type="checkbox" required id="termsCheck">
        <label class="form-check-label" for="termsCheck">
            When creating a new account, you agree to our <a href="#">terms of service</a> and <a href="#">privacy policy</a>.
        </label>
        </div>

        <button type="submit" class="btn btn-secondary w-100" disabled>Sign Up</button>
        <a href="login.html" class="login-link">Are you already registered? Log in</a>
    </form>
    </div>

    <script src="js/signup.js"></script>

</body>
</html>

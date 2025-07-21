<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Virtual Queuing System</title>
        <?php include 'php/config/base_config.php'; ?>
        <base href="<?php echo $baseUrl; ?>">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/index.css">
    </head>
    <body>

        <?php include 'header.php'; ?>
        <section class="hero">
            <div class="content text-center px-4">
                <h1 class="display-4 fw-bold">"Skip the Line. Save Your Time."</h1>
                <p class="lead mb-4">Join queues virtually and get real‑time updates — anywhere, anytime.</p>
                <a href="signup.php" class="btn btn-neutral btn-lg me-3">Sign Up</a>
                <a href="login.php" class="btn btn-outline-secondary btn-lg">Login</a>
            </div>
        </section>

        <?php include 'footer.php'; ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>

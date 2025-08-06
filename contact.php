<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Contact Us</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include 'php/config/base_config.php'; ?>
  <base href="<?php echo $baseUrl; ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="css/signup.css" />
  <link rel="stylesheet" href="css/index.css"/>
</head>
<body>
  <?php include 'header.php'; ?>
    <div class="signup-wrapper">
      <div class="signup-container">
        <div class="signup-logo">
          <img src="assets/img/queue.png" alt="Logo" />
        </div>
        <h2 class="mb-4 text-center">Contact Us</h2>

        <form id="contactForm" method="POST" action="php/send_contact.php">
          <div class="mb-3">
            <input type="text" name="name" id="name" class="form-control" placeholder="Your full name" required />
          </div>
          <div class="mb-3">
            <input type="email" name="email" id="email" class="form-control" placeholder="Your email" required />
          </div>
          <div class="mb-3">
            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject" required />
          </div>
          <div class="mb-3">
            <textarea name="message" id="message" rows="4" class="form-control" placeholder="Your message..." required></textarea>
          </div>
          <button type="submit" class="btn btn-secondary w-100">Send Message</button>
        </form>
      </div>
  </div>
 <?php include 'footer.php'; ?>
  <!-- Sweet Alert Dialog -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
      const name = document.getElementById('name').value.trim();
      const email = document.getElementById('email').value.trim();
      const subject = document.getElementById('subject').value.trim();
      const message = document.getElementById('message').value.trim();

      if (!name || !email || !subject || !message) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: 'All fields required',
          text: 'Please complete all fields before submitting.'
        });
      }
    });
  </script>
</body>
</html>

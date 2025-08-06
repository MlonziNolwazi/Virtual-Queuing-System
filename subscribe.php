<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Subscribe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <?php include 'php/config/base_config.php'; ?>
  <base href="<?php echo $baseUrl; ?>">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="stylesheet" href="css/signup.css" />
</head>
<body>
  <div class="subscribe-wrapper d-flex justify-content-center align-items-center">
    <div class="subscribe-container">
      <div class="signup-logo">
    
      </div>
    
      <form id="subscribeForm" method="POST" action="php/subscribe.php">
        

        <div class="mb-0">
          <input type="email" name="subscribe_email" id="subscribe_email" class="form-control" placeholder="Enter your email" required />
        </div>
        <button type="submit" class="btn btn-secondary w-100">Subscribe</button>
      </form>
    </div>
</div>
  <!-- Sweet Alert Dialog -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- JQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
  document.getElementById('subscribeForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const email = document.getElementById('subscribe_email').value.trim();

  if (!email) {
    Swal.fire({
      icon: 'error',
      title: 'Email required',
      text: 'Please enter your email.'
    });
    return;
  }

  $.ajax({
    type: 'POST',
    url: 'php/subscribe.php',
    data: { subscribe_email: email },
    success: function (response) {
      if (response.includes('success')) {
        Swal.fire({
          icon: 'success',
          title: 'Subscribed!',
          text: 'A confirmation email has been sent to you.'
        });
        $('#subscribeForm')[0].reset();
      } else {
        Swal.fire({
          icon: 'info',
          title: 'Notice',
          text: response
        });
      }
    },
    error: function () {
      Swal.fire({
        icon: 'error',
        title: 'Oops!',
        text: 'Something went wrong. Please try again.'
      });
    }
  });
});

  </script>
</body>
</html>

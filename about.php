<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>About - Smart-Q</title>
  <style>
    body {
      font-family: Arial, sans-serif;
     
      margin: 0;
      padding: 0;
    }
    .about-container {
      max-width: 960px;
      margin: auto;
      padding: 20px;
      background: #fff;
    }
    h1, h2 {
      color: #2c3e50;
    }
    p {
      line-height: 1.6;
      color: #333;
    }
    @media (max-width: 600px) {
      .about-container {
        padding: 10px;
      }
    }
  </style>
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
  <div class="about-container">
    <h1>About Smart-Q</h1>
    <p>The Smart-Q is an innovative web-based platform designed to streamline the way individuals access services from banks, clinics, government offices, and other institutions. By replacing physical lines with a smart, real-time queueing and appointment management system, the app offers a modern solution to a common frustration, waiting in line.</p>

    <h2>Our Mission</h2>
    <p>To eliminate long wait times and inefficient service delivery by providing a smart queueing solution that empowers users and enhances service provider operations.</p>


    <h2>Who Can Use It?</h2>
    <p>Any individual needing services from participating providers, and any organization that deals with queues or appointment-based services, including:</p>
    <ul>
      <li>Banks</li>
      <li>Clinics and Hospitals</li>
      <li>Government Offices</li>
      <li>Educational Institutions</li>
    </ul>

    <h2>Benefits</h2>
    <ul>
      <li>Save time and avoid unnecessary travel.</li>
      <li>Track your queue position in real-time.</li>
      <li>Book or reschedule appointments from anywhere.</li>
      <li>Improve efficiency for service providers.</li>
    </ul>

    <p>Join us in transforming service experiences, one virtual queue at a time!</p>
  </div>
   <?php include 'footer.php'; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
